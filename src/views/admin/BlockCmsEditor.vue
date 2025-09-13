<template>
  <AdminLayout>
    <div class="cms">
      <div class="pane left">
        <div class="toolbar">
          <input v-model="search" class="input" placeholder="ページ検索" @keyup.enter="loadPages" />
          <button class="btn" @click="openCreate">新規</button>
        </div>
        <div class="list">
          <div v-for="p in pages" :key="p.id" :class="['item',{active: currentPage && currentPage.id===p.id}]" @click="selectPage(p)">
            <div class="title">{{ p.title }}</div>
            <div class="slug">/{{ p.slug }}</div>
          </div>
        </div>
      </div>
      <div class="pane center">
        <div v-if="currentPage" class="editor-form">
          <div class="field">
            <label>KV画像</label>
            <div class="kv-uploader" @click="selectKvFile">
              <input ref="kvInput" type="file" accept="image/*" style="display:none" @change="onKvSelected" />
              <div v-if="kv.previewUrl" class="kv-preview" :style="{backgroundImage: `url(${kv.previewUrl})`}"></div>
              <div v-else class="kv-placeholder">
                <span class="kv-icon">🖼</span>
                <span>アップロードファイル</span>
              </div>
            </div>
            <div class="help">推奨比率 16:9（md/lgプリセットで自動リサイズ配信）</div>
          </div>

          <div class="field">
            <label>ページタイトル</label>
            <input v-model="currentPage.title" class="input" @change="savePageMeta" />
          </div>

          <!-- Layout view toggle (for key pages like company) -->
          <div class="field" v-if="currentPage && currentPage.slug==='company'">
            <label>編集モード</label>
            <div style="display:flex; gap:10px; align-items:center;">
              <label style="display:flex; gap:6px; align-items:center;">
                <input type="checkbox" v-model="layoutMode" /> ページ構成ビューで編集（実ページに近い配置）
              </label>
            </div>
          </div>

          <template v-if="showContentEditor">
            <div class="section-title">コンテンツ</div>
            <div class="field">
              <label>エディター</label>
              <textarea v-model="richText.html" class="textarea" rows="18" @change="saveRich"></textarea>
            </div>
            <div class="field">
              <label>本文用画像</label>
              <div style="display:flex; gap:8px; align-items:center;">
                <input ref="contentImgInput" type="file" accept="image/*" style="display:none" @change="onContentImageSelected" />
                <button class="btn" @click="selectContentImage">画像を選択</button>
                <button class="btn" @click="insertLastContentImage" :disabled="!lastContentImgUrl">本文に画像を追加</button>
                <span class="help" v-if="lastContentImgUrl">準備済み: {{ lastContentImgUrl }}</span>
              </div>
            </div>
          </template>

          <div v-if="currentPage" class="section-title">子コンポーネント文言（基本）</div>
          <div v-if="currentPage" class="field">
            <label>ページタイトル（見出し）</label>
            <input v-if="currentPage.slug==='privacy-policy'" v-model="privacyTexts.page_title" class="input" />
            <input v-else-if="currentPage.slug==='terms'" v-model="termsTexts.page_title" class="input" />
            <input v-else-if="currentPage.slug==='transaction-law'" v-model="tlTexts.page_title" class="input" />
            <input v-else-if="currentPage.slug==='cri-consulting'" v-model="consultingTexts.page_title" class="input" />
            <input v-else-if="currentPage.slug==='company'" v-model="companyTexts.page_title" class="input" />
            <input v-else-if="currentPage.slug==='aboutus'" v-model="aboutTexts.page_title" class="input" />
            <input v-else v-model="privacyTexts.page_title" class="input" />
          </div>
          <div v-if="currentPage" class="field">
            <label>サブタイトル</label>
            <input v-if="currentPage.slug==='privacy-policy'" v-model="privacyTexts.page_subtitle" class="input" />
            <input v-else-if="currentPage.slug==='terms'" v-model="termsTexts.page_subtitle" class="input" />
            <input v-else-if="currentPage.slug==='transaction-law'" v-model="tlTexts.page_subtitle" class="input" />
            <input v-else-if="currentPage.slug==='cri-consulting'" v-model="consultingTexts.page_subtitle" class="input" />
            <input v-else-if="currentPage.slug==='company'" v-model="companyTexts.page_subtitle" class="input" />
            <input v-else-if="currentPage.slug==='aboutus'" v-model="aboutTexts.page_subtitle" class="input" />
            <input v-else v-model="privacyTexts.page_subtitle" class="input" />
          </div>
          <div v-if="currentPage && currentPage.slug==='privacy-policy'" class="field">
            <label>導入文</label>
            <textarea v-model="privacyTexts.intro" class="textarea" rows="4"></textarea>
          </div>
          <div v-if="currentPage" class="actions" style="justify-content:flex-start; gap:8px;">
            <button class="btn" @click="savePrivacyTexts">文言を保存（PageContent）</button>
            <span class="help">ページ内のCmsTextに反映（公開デザインはそのまま）</span>
          </div>

          <!-- company / consulting / about: 動的テキスト一覧（小コンポーネント） -->
          <div v-if="currentPage && (currentPage.slug==='company' || currentPage.slug==='cri-consulting' || currentPage.slug==='aboutus')" class="section-title">小コンポーネントの文言一覧（texts）</div>
          <template v-if="currentPage && currentPage.slug==='company' && !layoutMode">
            <div class="field" v-for="(val, key) in companyTexts" :key="`company-${key}`">
              <label>{{ displayLabel(key) }}</label>
              <input v-model="companyTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in companyHtmls" :key="`company-html-${key}`">
              <label>{{ displayLabel(key, true) }}</label>
              <textarea v-model="companyHtmls[key]" class="textarea" rows="3"></textarea>
            </div>
            <!-- Company history (沿革) -->
            <div class="section-title">沿革（history）</div>
            <div class="help">年/日付/本文(HTML) を編集できます</div>
            <div v-for="(h, idx) in companyHistory" :key="`hist-${idx}`" class="field" style="border:1px solid #eee; padding:10px; border-radius:8px;">
              <label>年（year）</label>
              <input v-model="h.year" class="input" placeholder="例: 2011" />
              <label>日付（date）</label>
              <input v-model="h.date" class="input" placeholder="例: 平成23年7月1日" />
              <label>本文（HTML）</label>
              <textarea v-model="h.body" class="textarea" rows="3" placeholder="本文（HTML）"></textarea>
              <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:6px;">
                <button class="btn" @click="companyHistory.splice(idx,1)">削除</button>
                <button class="btn" @click="companyHistory.splice(Math.max(0, idx-1), 0, companyHistory.splice(idx,1)[0])" :disabled="idx===0">上へ</button>
                <button class="btn" @click="companyHistory.splice(Math.min(companyHistory.length, idx+2), 0, companyHistory.splice(idx,1)[0])" :disabled="idx===companyHistory.length-1">下へ</button>
              </div>
            </div>
            <div class="actions" style="justify-content:flex-start;">
              <button class="btn" @click="companyHistory.push({ year:'', date:'', body:'' })">+ 沿革を追加</button>
            </div>
          </template>

          <!-- Company: layout oriented editor -->
          <template v-if="currentPage && currentPage.slug==='company' && layoutMode">
            <!-- 経営理念（Philosophy） -->
            <div class="section-title">経営理念（Philosophy）</div>
            <div class="field">
              <label>見出し</label>
              <input v-model="companyTexts.philosophy_title" class="input" placeholder="経営理念" />
            </div>
            <div class="field">
              <label>英字</label>
              <input v-model="companyTexts.philosophy_subtitle" class="input" placeholder="philosophy" />
            </div>
            <div class="field">
              <label>MISSION ラベル</label>
              <input v-model="companyTexts.mission_label" class="input" placeholder="OUR MISSION" />
            </div>
            <div class="field">
              <label>MISSION 見出し</label>
              <input v-model="companyTexts.mission_title" class="input" placeholder="産官学金のネットワーク活用による地域貢献" />
            </div>
            <div class="field">
              <label>MISSION 本文（HTML）</label>
              <textarea v-model="companyHtmls.mission_body" class="textarea" rows="4"></textarea>
            </div>
            <div class="field">
              <label>セクション画像（company_profile_philosophy）</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_philosophy') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-key">images.company_profile_philosophy</div>
                  <div class="img-actions">
                    <input ref="img_company_profile_philosophy" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_philosophy', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_philosophy')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- ご挨拶（Message） -->
            <div class="section-title">ご挨拶（Message）</div>
            <div class="field">
              <label>見出し</label>
              <input v-model="companyTexts.message_title" class="input" placeholder="ご挨拶" />
            </div>
            <div class="field">
              <label>英字</label>
              <input v-model="companyTexts.message_subtitle" class="input" placeholder="message" />
            </div>
            <div class="field">
              <label>本文（HTML）</label>
              <textarea v-model="companyHtmls.message_body" class="textarea" rows="6"></textarea>
            </div>
            <div class="field">
              <label>署名</label>
              <input v-model="companyTexts.message_signature" class="input" placeholder="代表取締役社長 ・・・" />
            </div>
            <div class="field">
              <label>セクション画像（company_profile_message）</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_message') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-key">images.company_profile_message</div>
                  <div class="img-actions">
                    <input ref="img_company_profile_message" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_message', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_message')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 会社概要（Company Profile） -->
            <div class="section-title">会社概要（Company Profile）</div>
            <div class="field">
              <label>見出し</label>
              <input v-model="companyTexts.profile_title" class="input" placeholder="会社概要" />
            </div>
            <div class="field">
              <label>英字</label>
              <input v-model="companyTexts.profile_subtitle" class="input" placeholder="company profile" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_company_name_label') }}</label>
              <input v-model="companyTexts.profile_company_name_label" class="input" />
              <label>{{ displayLabel('profile_company_name_value') }}</label>
              <input v-model="companyTexts.profile_company_name_value" class="input" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_established_label') }}</label>
              <input v-model="companyTexts.profile_established_label" class="input" />
              <label>{{ displayLabel('profile_established_value') }}</label>
              <input v-model="companyTexts.profile_established_value" class="input" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_address_label') }}</label>
              <input v-model="companyTexts.profile_address_label" class="input" />
              <label>{{ displayLabel('profile_address_value', true) }}</label>
              <textarea v-model="companyHtmls.profile_address_value" class="textarea" rows="3"></textarea>
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_representative_label') }}</label>
              <input v-model="companyTexts.profile_representative_label" class="input" />
              <label>{{ displayLabel('profile_representative_value') }}</label>
              <input v-model="companyTexts.profile_representative_value" class="input" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_capital_label') }}</label>
              <input v-model="companyTexts.profile_capital_label" class="input" />
              <label>{{ displayLabel('profile_capital_value') }}</label>
              <input v-model="companyTexts.profile_capital_value" class="input" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_shareholders_label') }}</label>
              <input v-model="companyTexts.profile_shareholders_label" class="input" />
              <label>{{ displayLabel('profile_shareholders_value') }}</label>
              <input v-model="companyTexts.profile_shareholders_value" class="input" />
            </div>
            <div class="field">
              <label>{{ displayLabel('profile_organization_label') }}</label>
              <input v-model="companyTexts.profile_organization_label" class="input" />
              <label>{{ displayLabel('profile_organization_value') }}</label>
              <input v-model="companyTexts.profile_organization_value" class="input" />
            </div>

            <!-- 沿革（History） -->
            <div class="section-title">沿革（History）</div>
            <div class="help">年/日付/本文(HTML) を編集できます</div>
            <div v-for="(h, idx) in companyHistory" :key="`hist-l-${idx}`" class="field" style="border:1px solid #eee; padding:10px; border-radius:8px;">
              <label>年（year）</label>
              <input v-model="h.year" class="input" placeholder="例: 2011" />
              <label>日付（date）</label>
              <input v-model="h.date" class="input" placeholder="例: 平成23年7月1日" />
              <label>本文（HTML）</label>
              <textarea v-model="h.body" class="textarea" rows="3" placeholder="本文（HTML）"></textarea>
              <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:6px;">
                <button class="btn" @click="companyHistory.splice(idx,1)">削除</button>
                <button class="btn" @click="companyHistory.splice(Math.max(0, idx-1), 0, companyHistory.splice(idx,1)[0])" :disabled="idx===0">上へ</button>
                <button class="btn" @click="companyHistory.splice(Math.min(companyHistory.length, idx+2), 0, companyHistory.splice(idx,1)[0])" :disabled="idx===companyHistory.length-1">下へ</button>
              </div>
            </div>
            <div class="actions" style="justify-content:flex-start; gap:8px;">
              <button class="btn" @click="companyHistory.push({ year:'', date:'', body:'' })">+ 沿革を追加</button>
              <button class="btn primary" @click="savePrivacyTexts">文言を保存（PageContent）</button>
            </div>

            <!-- 所員紹介（Staff） -->
            <div class="section-title">所員紹介（Staff）</div>
            <div class="field">
              <label>見出し</label>
              <input v-model="companyTexts.staff_title" class="input" placeholder="所員紹介" />
            </div>
            <div class="field">
              <label>英字</label>
              <input v-model="companyTexts.staff_subtitle" class="input" placeholder="About us" />
            </div>
            <div class="field">
              <label>写真（森田） company_profile_staff_morita</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_staff_morita') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-actions">
                    <input ref="img_company_profile_staff_morita" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_staff_morita', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_staff_morita')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label>写真（溝上） company_profile_staff_mizokami</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_staff_mizokami') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-actions">
                    <input ref="img_company_profile_staff_mizokami" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_staff_mizokami', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_staff_mizokami')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label>写真（空閑） company_profile_staff_kuga</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_staff_kuga') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-actions">
                    <input ref="img_company_profile_staff_kuga" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_staff_kuga', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_staff_kuga')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label>写真（髙田） company_profile_staff_takada</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_staff_takada') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-actions">
                    <input ref="img_company_profile_staff_takada" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_staff_takada', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_staff_takada')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label>写真（中村） company_profile_staff_nakamura</label>
              <div class="page-image-row">
                <div class="img-preview"><img :src="getImageUrlByKey('company_profile_staff_nakamura') || ''" alt="preview"/></div>
                <div class="img-meta">
                  <div class="img-actions">
                    <input ref="img_company_profile_staff_nakamura" type="file" accept="image/*" style="display:none" @change="onCompanyImageSelected('company_profile_staff_nakamura', $event)" />
                    <button class="btn" @click="triggerCompanyImageUpload('company_profile_staff_nakamura')">アップロードファイル</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 決算報告（Financial Reports） -->
            <div class="section-title">決算報告（Financial Reports）</div>
            <div class="field">
              <label>見出し</label>
              <input v-model="companyTexts.financial_reports_title" class="input" placeholder="決算報告" />
            </div>
            <div class="field">
              <label>英字</label>
              <input v-model="companyTexts.financial_reports_subtitle" class="input" placeholder="financial reports" />
            </div>
            <div class="help">決算データは別管理（自動表示）です。タイトルのみ編集できます。</div>

          </template>
          <template v-if="currentPage && currentPage.slug==='cri-consulting'">
            <div class="field" v-for="(val, key) in consultingTexts" :key="`consult-${key}`">
              <label>{{ displayLabel(key) }}</label>
              <input v-model="consultingTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in consultingHtmls" :key="`consult-html-${key}`">
              <label>{{ displayLabel(key, true) }}</label>
              <textarea v-model="consultingHtmls[key]" class="textarea" rows="3"></textarea>
            </div>
          </template>
          <template v-if="currentPage && currentPage.slug==='aboutus'">
            <div class="field" v-for="(val, key) in aboutTexts" :key="`about-${key}`">
              <label>{{ displayLabel(key) }}</label>
              <input v-model="aboutTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in aboutHtmls" :key="`about-html-${key}`">
              <label>{{ displayLabel(key, true) }}</label>
              <textarea v-model="aboutHtmls[key]" class="textarea" rows="3"></textarea>
            </div>
          </template>

          <!-- glossary: 用語リスト編集 -->
          <div v-if="currentPage && currentPage.slug==='glossary'" class="section-title">用語リスト（items）</div>
          <template v-if="currentPage && currentPage.slug==='glossary'">
            <div class="help">用語（term / category / definition(HTML)）を編集・追加できます</div>
            <div v-for="(it, idx) in glossaryItems" :key="`gls-${idx}`" class="field" style="border:1px solid #eee; padding:10px; border-radius:8px;">
              <label>用語（term）</label>
              <input v-model="it.term" class="input" placeholder="例: CPI" />
              <label>カテゴリ（category）</label>
              <input v-model="it.category" class="input" placeholder="例: economic" />
              <label>定義（HTML）</label>
              <textarea v-model="it.definition" class="textarea" rows="4" placeholder="定義をHTMLで入力"></textarea>
              <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:6px;">
                <button class="btn" @click="glossaryItems.splice(idx,1)">削除</button>
                <button class="btn" @click="glossaryItems.splice(Math.max(0, idx-1), 0, glossaryItems.splice(idx,1)[0])" :disabled="idx===0">上へ</button>
                <button class="btn" @click="glossaryItems.splice(Math.min(glossaryItems.length, idx+2), 0, glossaryItems.splice(idx,1)[0])" :disabled="idx===glossaryItems.length-1">下へ</button>
              </div>
            </div>
            <div class="actions" style="justify-content:flex-start;">
              <button class="btn" @click="glossaryItems.push({ term:'', category:'', definition:'' })">+ 用語を追加</button>
            </div>
          </template>

          <!-- FAQ: Q/A リスト編集 -->
          <div v-if="currentPage && currentPage.slug==='faq'" class="section-title">FAQ 項目（faqs）</div>
          <template v-if="currentPage && currentPage.slug==='faq'">
            <div class="help">カテゴリ/質問/回答(HTML)/タグ（カンマ区切り）を編集・追加できます</div>
            <div v-for="(fq, idx) in faqItems" :key="`faq-${idx}`" class="field" style="border:1px solid #eee; padding:10px; border-radius:8px;">
              <label>カテゴリ</label>
              <input v-model="fq.category" class="input" placeholder="all | service | membership | research" />
              <label>質問</label>
              <input v-model="fq.question" class="input" placeholder="質問文" />
              <label>回答（HTML）</label>
              <textarea v-model="fq.answer" class="textarea" rows="4" placeholder="回答HTML"></textarea>
              <label>タグ（カンマ区切り）</label>
              <input :value="(Array.isArray(fq.tags)? fq.tags.join(', ') : '')" @input="(e)=>{ const v=e.target.value||''; fq.tags = v.split(',').map(s=>s.trim()).filter(Boolean) }" class="input" placeholder="例: 会費,手続き" />
              <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:6px;">
                <button class="btn" @click="faqItems.splice(idx,1)">削除</button>
                <button class="btn" @click="faqItems.splice(Math.max(0, idx-1), 0, faqItems.splice(idx,1)[0])" :disabled="idx===0">上へ</button>
                <button class="btn" @click="faqItems.splice(Math.min(faqItems.length, idx+2), 0, faqItems.splice(idx,1)[0])" :disabled="idx===faqItems.length-1">下へ</button>
              </div>
            </div>
            <div class="actions" style="justify-content:flex-start;">
              <button class="btn" @click="faqItems.push({ category:'all', question:'', answer:'', tags:[], _id: faqItems.length })">+ FAQを追加</button>
            </div>
          </template>

          <!-- フォールバック: 汎用のtexts/htmlsエディタ（除外ページ以外） -->
          <template v-if="currentPage && showGenericEditor">
            <div class="section-title">子コンポーネント文言（基本）</div>
            <div class="field" v-for="(val, key) in genericTexts" :key="`gtext-${key}`">
              <label>{{ displayLabel(key) }}</label>
              <input v-model="genericTexts[key]" class="input" />
            </div>
            <div class="section-title">セクション別文言（HTML）</div>
            <div class="field" v-for="(val, key) in genericHtmls" :key="`ghtml-${key}`">
              <label>{{ displayLabel(key, true) }}</label>
              <textarea v-model="genericHtmls[key]" class="textarea" rows="3"></textarea>
            </div>
          </template>

          <!-- privacy-policy: section-wise fields -->
          <div v-if="currentPage.slug==='privacy-policy'" class="section-title">セクション別文言</div>
          <!-- 1. 収集 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>1. 個人情報の収集（見出し）</label>
            <input v-model="privacyTexts.collection_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>1. 個人情報の収集（本文）</label>
            <textarea v-model="privacyTexts.collection_body" class="textarea" rows="4"></textarea>
          </div>
          <!-- 2. 利用目的 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（見出し）</label>
            <input v-model="privacyTexts.purpose_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（導入文）</label>
            <textarea v-model="privacyTexts.purpose_intro" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>2. 個人情報の利用目的（リストHTML）</label>
            <textarea v-model="privacyTexts.purpose_list" class="textarea" rows="5" placeholder="<ul>は不要。<br>区切りで入力"></textarea>
          </div>
          <!-- 3. 第三者提供 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>3. 個人情報の第三者提供（見出し）</label>
            <input v-model="privacyTexts.disclosure_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>3. 個人情報の第三者提供（リストHTML）</label>
            <textarea v-model="privacyTexts.disclosure_list" class="textarea" rows="5"></textarea>
          </div>
          <!-- 4. 開示・訂正・削除 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>4. 個人情報の開示・訂正・削除（見出し）</label>
            <input v-model="privacyTexts.correction_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>4. 個人情報の開示・訂正・削除（本文HTML）</label>
            <textarea v-model="privacyTexts.correction_body" class="textarea" rows="5"></textarea>
          </div>
          <!-- 免責 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（見出し）</label>
            <input v-model="privacyTexts.disclaimer_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文1）</label>
            <textarea v-model="privacyTexts.disclaimer_body1" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文2）</label>
            <textarea v-model="privacyTexts.disclaimer_body2" class="textarea" rows="3"></textarea>
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>免責事項（本文3）</label>
            <textarea v-model="privacyTexts.disclaimer_body3" class="textarea" rows="3"></textarea>
          </div>
          <!-- 変更告知 -->
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>プライバシーポリシーの変更（見出し）</label>
            <input v-model="privacyTexts.changes_title" class="input" />
          </div>
          <div v-if="currentPage.slug==='privacy-policy'" class="field">
            <label>プライバシーポリシーの変更（本文）</label>
            <textarea v-model="privacyTexts.changes_body" class="textarea" rows="3"></textarea>
          </div>

          <!-- 利用規約 セクション別文言 -->
          <div v-if="currentPage.slug==='terms'" class="section-title">セクション別文言（利用規約）</div>
          <template v-if="currentPage.slug==='terms'">
            <div class="field"><label>導入文（HTML）</label><textarea v-model="termsHtmls.intro" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>著作権（見出し）</label><input v-model="termsTexts.copyright_title" class="input" /></div>
            <div class="field"><label>著作権（本文HTML）</label><textarea v-model="termsHtmls.copyright_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>リンク（見出し）</label><input v-model="termsTexts.link_title" class="input" /></div>
            <div class="field"><label>リンク（本文HTML）</label><textarea v-model="termsHtmls.link_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>免責事項（見出し）</label><input v-model="termsTexts.disclaimer_title" class="input" /></div>
            <div class="field"><label>免責事項（本文HTML）</label><textarea v-model="termsHtmls.disclaimer_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>セキュリティ（見出し）</label><input v-model="termsTexts.security_title" class="input" /></div>
            <div class="field"><label>セキュリティ（本文HTML）</label><textarea v-model="termsHtmls.security_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>クッキー（見出し）</label><input v-model="termsTexts.cookie_title" class="input" /></div>
            <div class="field"><label>クッキー（本文HTML）</label><textarea v-model="termsHtmls.cookie_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>ご利用環境（見出し）</label><input v-model="termsTexts.environment_title" class="input" /></div>
            <div class="field"><label>ご利用環境（本文HTML）</label><textarea v-model="termsHtmls.environment_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>禁止される行為（見出し）</label><input v-model="termsTexts.prohibited_title" class="input" /></div>
            <div class="field"><label>禁止される行為（本文HTML）</label><textarea v-model="termsHtmls.prohibited_body" class="textarea" rows="4"></textarea></div>
            <div class="field"><label>第8条（見出し）</label><input v-model="termsTexts.article8_title" class="input" /></div>
            <div class="field"><label>第8条（本文HTML）</label><textarea v-model="termsHtmls.article8_body" class="textarea" rows="4"></textarea></div>
          </template>

          <!-- 特定商取引法 セクション別文言 -->
          <div v-if="currentPage.slug==='transaction-law'" class="section-title">セクション別文言（特定商取引法）</div>
          <template v-if="currentPage.slug==='transaction-law'">
            <div class="field"><label>販売業者（ラベル）</label><input v-model="tlTexts.seller_label" class="input" /></div>
            <div class="field"><label>販売業者（値）</label><input v-model="tlTexts.seller_value" class="input" /></div>
            <div class="field"><label>代表者名（ラベル）</label><input v-model="tlTexts.rep_label" class="input" /></div>
            <div class="field"><label>代表者名（値）</label><input v-model="tlTexts.rep_value" class="input" /></div>
            <div class="field"><label>住所（ラベル）</label><input v-model="tlTexts.addr_label" class="input" /></div>
            <div class="field"><label>住所（HTML）</label><textarea v-model="tlHtmls.addr_value" class="textarea" rows="3"></textarea></div>
            <div class="field"><label>電話番号（ラベル）</label><input v-model="tlTexts.tel_label" class="input" /></div>
            <div class="field"><label>電話番号（値）</label><input v-model="tlTexts.tel_value" class="input" /></div>
            <div class="field"><label>FAX番号（ラベル）</label><input v-model="tlTexts.fax_label" class="input" /></div>
            <div class="field"><label>FAX番号（値）</label><input v-model="tlTexts.fax_value" class="input" /></div>
            <div class="field"><label>メール（ラベル）</label><input v-model="tlTexts.mail_label" class="input" /></div>
            <div class="field"><label>メール（値）</label><input v-model="tlTexts.mail_value" class="input" /></div>
            <div class="field"><label>お問い合わせCTA</label><input v-model="tlTexts.contact_cta" class="input" /></div>
            <div class="field"><label>料金（ラベル）</label><input v-model="tlTexts.fee_label" class="input" /></div>
            <div class="field"><label>料金（説明HTML）</label><textarea v-model="tlHtmls.fee_desc" class="textarea" rows="3"></textarea></div>
            <div class="field"><label>料金セクション見出し</label><input v-model="tlTexts.fee_section_title" class="input" /></div>
            <div class="field"><label>スタンダード会員（見出し）</label><input v-model="tlTexts.fee_standard_label" class="input" /></div>
            <div class="field"><label>スタンダード会員（金額）</label><input v-model="tlTexts.fee_standard_amount" class="input" /></div>
            <div class="field"><label>プレミアムネット会員（見出し）</label><input v-model="tlTexts.fee_premium_label" class="input" /></div>
            <div class="field"><label>プレミアムネット会員（金額）</label><input v-model="tlTexts.fee_premium_amount" class="input" /></div>
            <div class="field"><label>支払い時期および方法（ラベル）</label><input v-model="tlTexts.payment_label" class="input" /></div>
            <div class="field"><label>支払い時期および方法（本文HTML）</label><textarea v-model="tlHtmls.payment_body" class="textarea" rows="3"></textarea></div>
            <div class="field"><label>その他料金（ラベル）</label><input v-model="tlTexts.otherfees_label" class="input" /></div>
            <div class="field"><label>その他料金（値）</label><input v-model="tlTexts.otherfees_value" class="input" /></div>
            <div class="field"><label>提供時間（ラベル）</label><input v-model="tlTexts.service_time_label" class="input" /></div>
            <div class="field"><label>提供時間（値）</label><input v-model="tlTexts.service_time_value" class="input" /></div>
            <div class="field"><label>退会（ラベル）</label><input v-model="tlTexts.cancel_label" class="input" /></div>
            <div class="field"><label>退会（値）</label><input v-model="tlTexts.cancel_value" class="input" /></div>
            <div class="field"><label>返金（ラベル）</label><input v-model="tlTexts.refund_label" class="input" /></div>
            <div class="field"><label>返金（本文HTML）</label><textarea v-model="tlHtmls.refund_body" class="textarea" rows="3"></textarea></div>
            <div class="field"><label>会員規約注記</label><input v-model="tlTexts.terms_note" class="input" /></div>
          </template>

          <div class="actions-row">
            <button class="btn primary" :disabled="!currentPage" @click="publish">公開する</button>
            <button class="btn" :disabled="!currentPage" @click="unpublish">公開を停止する</button>
            <button class="btn" :disabled="!currentPage" @click="issuePreview">プレビューリンク</button>
            <a v-if="previewUrl" :href="previewUrl" target="_blank" rel="noopener" class="btn">開く</a>
          </div>

          <div v-if="currentPage" class="actions-row" style="margin-top:8px;">
            <button class="btn" @click="importExistingPrivacy">既存文言を取り込む</button>
            <button class="btn" @click="syncRichToPageContentHtml">本文をPageContentに同期</button>
          </div>
        <div v-if="currentPage" class="field" style="margin-top:8px;">
          <label>PageContentのページキー（必要に応じて変更）</label>
          <input v-model="pageContentKey" class="input" placeholder="privacy / privacy-poricy など" />
          <div class="help">取り込み/保存はこのキーで行います</div>
        </div>

        <!-- Page images management (optional) -->
        <div v-if="currentPage" class="section-title" style="display:flex; align-items:center; gap:8px;">
          ページ内画像（content.images）
          <label style="margin-left:auto; font-weight:normal; font-size:12px; color:#555; display:flex; gap:6px; align-items:center;">
            <input type="checkbox" v-model="showImageList" /> 一覧を表示
          </label>
        </div>
        <div v-if="currentPage && showImageList" class="field">
          <div v-if="pageImages.length === 0" class="help">登録済みの画像がありません</div>
          <div v-for="(img, idx) in pageImages" :key="`pimg-${idx}`" class="page-image-row">
            <div class="img-preview" v-if="img.url"><img :src="img.url" alt="preview"/></div>
            <div class="img-meta">
              <div class="img-key">{{ img.key }}</div>
              <div class="img-file">{{ img.filename || '' }}</div>
              <div class="img-actions">
                <input :ref="`replace_${idx}`" type="file" accept="image/*" style="display:none" @change="onReplacePageImage(idx, $event)" />
                <button class="btn" @click="triggerReplace(idx)">差し替え</button>
              </div>
            </div>
          </div>
          <div class="actions-row" style="margin-top:8px; gap:8px; align-items:center;">
            <input v-model="newImageKey" class="input" placeholder="新規キー（例: hero, content.main など）" style="max-width:260px" />
            <input ref="newImageInput" type="file" accept="image/*" style="display:none" @change="onAddNewPageImage" />
            <button class="btn" @click="triggerAddNew">新規追加</button>
            <span class="help">キー未入力の場合は追加できません</span>
          </div>
        </div>
      </div>
      <div v-else class="empty">ページを選択してください</div>
    </div>
      <div class="pane right" style="display:none"></div>
    </div>

    <!-- Create modal -->
    <div v-if="showCreate" class="modal" @click="showCreate=false">
      <div class="modal-inner" @click.stop>
        <h3>新規ページ</h3>
        <div class="field"><label>Slug</label><input v-model="createForm.slug" class="input" placeholder="about, terms など"/></div>
        <div class="field"><label>タイトル</label><input v-model="createForm.title" class="input"/></div>
        <div class="actions"><button class="btn" @click="create">作成</button></div>
      </div>
    </div>
  </AdminLayout>
  
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import apiClient from '@/services/apiClient'
import { getApiUrl } from '@/config/api.js'

export default {
  name: 'BlockCmsEditor',
  components: { AdminLayout },
  data(){
      return {
      pages: [],
      search: '',
      currentPage: null,
      sections: [],
      hero: { title: '' },
      richText: { html: '' },
      warnings: [],
      showCreate: false,
      createForm: { slug: '', title: '' },
      previewUrl: '',
      kv: { id:'', ext:'', previewUrl:'' },
      lastContentImgUrl: '',
      // エディタ（本文）の表示切替。既定は非表示
      showContentEditor: false,
      // ページ構成ビュー（実ページに近い配置で編集）
      layoutMode: false,
      privacyTexts: {
        page_title: '', page_subtitle: '', intro: '',
        collection_title: '', collection_body: '',
        purpose_title: '', purpose_intro: '', purpose_list: '',
        disclosure_title: '', disclosure_list: '',
        correction_title: '', correction_body: '',
        disclaimer_title: '', disclaimer_body1: '', disclaimer_body2: '', disclaimer_body3: '',
        changes_title: '', changes_body: '',
      },
      // 利用規約（セクション別）: APIから動的にマージするため空で初期化
      termsTexts: {},
      termsHtmls: {},
      // 特定商取引法（セクション別）: APIから動的にマージするため空で初期化
      tlTexts: {},
      tlHtmls: {},
      // 会社概要 / コンサル / 研究所について（小コンポーネント文言）
      companyTexts: {},
      companyHtmls: {},
      consultingTexts: {},
      consultingHtmls: {},
      aboutTexts: {},
      aboutHtmls: {},
      // 一般ページ用: 動的に全texts/htmlsを編集するフォールバック
      genericTexts: {},
      genericHtmls: {},
      // Page images (content.images)
      pageImages: [],
      showImageList: false,
      newImageKey: '',
      // glossary: 用語リスト（items）の編集
        glossaryItems: [],
        // faq: Q/A リストの編集
        faqItems: [],
        companyHistory: [],
      // 日本語表示用のラベルマップ（スラッグ別）
      labelMaps: {
        // トップ
        home: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          about_title: '研究所について（見出し）', about_subtitle: '研究所について（英字）',
          about_body: '研究所について（本文）',
          cta_secondary: 'ボタン（研究所について詳しく）'
        },
        company: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          nav_philosophy: 'ナビ: 経営理念', nav_message: 'ナビ: ご挨拶', nav_profile: 'ナビ: 企業概要', nav_history: 'ナビ: 沿革', nav_staff: 'ナビ: 所員紹介', nav_financial: 'ナビ: 決算報告', nav_access: 'ナビ: アクセス',
          philosophy_title: '経営理念（見出し）', philosophy_subtitle: '経営理念（英字）',
          mission_label: 'OUR MISSION（ラベル）', mission_title: 'ミッション（見出し）',
          message_title: 'ご挨拶（見出し）', message_subtitle: 'ご挨拶（英字）', message_label: 'ご挨拶（ラベル）', message_signature: 'ご挨拶（署名）',
          profile_title: '会社概要（見出し）', profile_subtitle: '会社概要（英字）',
          profile_company_name_label: '会社名（ラベル）', profile_company_name_value: '会社名（値）',
          profile_established_label: '設立（ラベル）', profile_established_value: '設立（値）',
          profile_address_label: '住所（ラベル）', profile_address_value: '住所（値・HTML可）',
          profile_representative_label: '代表者（ラベル）', profile_representative_value: '代表者（値）',
          profile_capital_label: '資本金（ラベル）', profile_capital_value: '資本金（値）',
          profile_shareholders_label: '株主（ラベル）', profile_shareholders_value: '株主（値）',
          profile_organization_label: '組織体制（ラベル）', profile_organization_value: '組織体制（値）',
          history_title: '沿革（見出し）', history_subtitle: '沿革（英字）',
          staff_title: '所員紹介（見出し）', staff_subtitle: '所員紹介（英字）',
          // HTMLs
          message_body: 'ご挨拶（本文）', mission_body: 'ミッション（本文）'
        },
        'cri-consulting': {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          what_title: '「CRI経営コンサルティングとは？」（見出し）', what_subtitle: '（英字）',
          what_content_subtitle: '説明サブ見出し', what_content_heading: '説明見出し',
          duties_title: '主な業務（見出し）', duties_subtitle: '主な業務（英字）', duties_label: '主な業務（ラベル）', duties_heading: '主な業務（説明見出し）',
          support_title: 'サポート内容と費用（見出し）', support_subtitle_en: 'サポート（英字）',
          achievements_title: '実績紹介（見出し）', achievements_subtitle: '実績紹介（英字）',
          cta_primary: 'お問い合わせボタン文言', cta_secondary: '入会ボタン文言',
          // HTMLs
          what_content_body: '説明（本文）', duties_intro: '主な業務（導入文）', duties_list: '主な業務（リストHTML）', support_intro: 'サポート（導入文）',
          // 実績（任意）
          achievements_item1_date: '実績1 日付', achievements_item1_category: '実績1 カテゴリ', achievements_item1_title: '実績1 タイトル', achievements_item1_desc: '実績1 説明（HTML）',
          achievements_item2_date: '実績2 日付', achievements_item2_category: '実績2 カテゴリ', achievements_item2_title: '実績2 タイトル', achievements_item2_desc: '実績2 説明（HTML）',
          achievements_item3_date: '実績3 日付', achievements_item3_category: '実績3 カテゴリ', achievements_item3_title: '実績3 タイトル', achievements_item3_desc: '実績3 説明（HTML）',
          achievements_item4_date: '実績4 日付', achievements_item4_category: '実績4 カテゴリ', achievements_item4_title: '実績4 タイトル', achievements_item4_desc: '実績4 説明（HTML）'
        },
        aboutus: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          about_title: '研究所について（見出し）', about_subtitle: '研究所について（英字）',
          service_title: 'サービス概要（見出し）', service_subtitle: 'サービス概要（英字）',
          service1_title: 'サービス1（見出し）', service1_desc: 'サービス1（説明）', service1_list: 'サービス1（リストHTML）',
          service2_title: 'サービス2（見出し）', service2_desc: 'サービス2（説明）', service2_list: 'サービス2（リストHTML）',
          service3_title: 'サービス3（見出し）', service3_desc: 'サービス3（説明）', service3_list: 'サービス3（リストHTML）',
          main_headline: 'ヒーロー見出し（HTML）',
          cta_primary: 'お問い合わせボタン文言', cta_secondary: '入会ボタン文言',
          // HTMLs
          about_body: '研究所について（本文）'
        }
        ,
        // 利用規約
        terms: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          copyright_title: '著作権等について（見出し）', link_title: 'リンクについて（見出し）', disclaimer_title: '免責事項（見出し）',
          security_title: 'セキュリティについて（見出し）', cookie_title: 'クッキーについて（見出し）', environment_title: 'ご利用環境について（見出し）',
          prohibited_title: '禁止される行為（見出し）', article8_title: '第8条（見出し）',
          // HTMLs
          intro: '導入（本文）', copyright_body: '著作権等について（本文）', link_body: 'リンクについて（本文）', disclaimer_body: '免責事項（本文）',
          security_body: 'セキュリティについて（本文）', cookie_body: 'クッキーについて（本文）', environment_body: 'ご利用環境について（本文）',
          prohibited_body: '禁止される行為（本文）', article8_body: '第8条（本文）'
        },
        // 会員（入会案内）
        membership: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          intro_title: '導入（見出し）', intro_text: '導入（本文）',
          services_title: 'サービス（見出し）', services_label: 'サービス（英字）',
          premium_category_title: 'プレミアサービス（見出し）',
          premium_service1_tag: 'プレミア項目1（タグ）', premium_service1_name: 'プレミア項目1（名称）',
          standard_premium_category_title: 'スタンダード＆プレミア（見出し）',
          standard_service1_tag: '項目1（タグ）', standard_service1_name: '項目1（名称）',
          standard_service2_tag: '項目2（タグ）', standard_service2_name: '項目2（名称）',
          standard_service3_tag: '項目3（タグ）', standard_service3_name: '項目3（名称）',
          standard_service4_tag: '項目4（タグ）', standard_service4_name: '項目4（名称）',
          standard_service5_tag: '項目5（タグ）', standard_service5_name: '項目5（名称）',
          membership_info_title: '会員サービスについて（見出し）',
          membership_benefits_label: '会員のメリット（ラベル）', membership_benefits_text: '会員のメリット（本文）',
          membership_fee_label: '月会費（ラベル）', membership_fee_text: '月会費（本文）',
          flow_title: '入会までの流れ（見出し）', flow_label: '入会までの流れ（英字）',
          step1_title: 'STEP1（見出し）', step1_desc: 'STEP1（説明）',
          step2_title: 'STEP2（見出し）', step2_desc: 'STEP2（説明）',
          step3_title: 'STEP3（見出し）', step4_title: 'STEP4（見出し）',
          cta_primary: 'お問い合わせボタン文言', cta_secondary: '入会ボタン文言'
        },
        'standard-membership': {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          intro_title: '導入（見出し）', intro_text: '導入（本文）',
          services_title: '主なサービス（見出し）', services_label: 'サービス（英字）',
          standard_category_title: 'スタンダードサービス（見出し）',
          standard_service1_tag: '項目1（タグ）', standard_service1_name: '項目1（名称）',
          standard_service2_tag: '項目2（タグ）', standard_service2_name: '項目2（名称）',
          standard_service3_tag: '項目3（タグ）', standard_service3_name: '項目3（名称）',
          standard_service4_tag: '項目4（タグ）', standard_service4_name: '項目4（名称）',
          standard_service5_tag: '項目5（タグ）', standard_service5_name: '項目5（名称）',
          membership_info_title: '会員サービスについて（見出し）',
          membership_benefits_label: '会員のメリット（ラベル）', membership_benefits_text: '会員のメリット（本文）',
          membership_fee_label: '月会費（ラベル）', membership_fee_text: '月会費（本文）',
          flow_title: '入会までの流れ（見出し）', flow_label: '入会までの流れ（英字）',
          step1_title: 'STEP1（見出し）', step1_desc: 'STEP1（説明）',
          step2_title: 'STEP2（見出し）', step2_desc: 'STEP2（説明）',
          step3_title: 'STEP3（見出し）', step4_title: 'STEP4（見出し）',
          cta_primary: 'お問い合わせボタン文言', cta_secondary: '入会ボタン文言'
        },
        'premium-membership': {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          benefits_title: '話題の特典（見出し）', benefits_label: '話題の特典（英字）',
          featured_title: '特集（見出し）', featured_body: '特集（本文）', featured_cta: '特集CTA',
          cta_primary: 'お問い合わせボタン文言', cta_secondary: '入会ボタン文言'
        },
        sitemap: {
          intro: '導入文',
          cat_main: 'カテゴリ: メイン', cat_services: 'カテゴリ: サービス', cat_membership: 'カテゴリ: 会員', cat_support: 'カテゴリ: サポート', cat_legal: 'カテゴリ: 法務',
          link_home: 'リンク: ホーム', link_company: 'リンク: 会社概要', link_about: 'リンク: 研究所について', link_seminar: 'リンク: セミナー', link_publications: 'リンク: 刊行物', link_consulting: 'リンク: コンサルティング', link_research: 'リンク: 調査研究', link_training: 'リンク: 研修', link_membership: 'リンク: 入会案内', link_news: 'リンク: お知らせ', link_faq: 'リンク: FAQ', link_contact: 'リンク: お問い合わせ', link_privacy: 'リンク: プライバシー', link_terms: 'リンク: 利用規約', link_legal: 'リンク: 特商法'
        },
        glossary: {
          page_title: 'ページタイトル', page_subtitle: 'ページサブタイトル',
          intro: '導入（本文）',
          contact_title: '問合せ（見出し）', contact_subtitle: '問合せ（説明）', contact_label: '問合せ（英字）', contact_cta: '問合せボタン'
        }
      },
      // PageContent(CmsText) 側のキー。ページ選択時に推定（UIで変更可）
      pageContentKey: 'privacy',
    }
  },
  mounted(){ this.loadPages() },
  computed: {
    // 除外ページ: 刊行物/お知らせ/セミナー/経済統計・指標/会員ログイン/マイページ/お問い合わせ
    excludeKeys(){
      return new Set([
        'publications','publications-public','news','notice','notices',
        'seminars','seminars-current','seminars-past',
        'economic-reports','statistics','economic-indicators',
        'login','my-account'
      ])
    },
    showGenericEditor(){
      const key = (this.pageContentKey || '').trim()
      if (!key) return false
      if (this.excludeKeys.has(key)) return false
      // 既に専用UIがあるものは除外
      const specialized = new Set(['privacy','terms','transaction-law','company-profile','consulting','about-institute'])
      if (specialized.has(key)) return false
      // texts/htmls のどちらかがあるときに表示
      const hasTexts = this.genericTexts && Object.keys(this.genericTexts).length > 0
      const hasHtmls = this.genericHtmls && Object.keys(this.genericHtmls).length > 0
      return hasTexts || hasHtmls
    },
    }
  },
  methods: {
    // preview helpers removed
    async loadPages(){
      const res = await apiClient.listCmsPages({ search: this.search, per_page: 100 })
      if (res.success) this.pages = res.data.data || []
      // Enhance titles with current PageContent page_title where available
      try { await this.applyPrettyTitles() } catch(_) {}
      // auto-select by route param or query
      const slug = this.$route.params.slug || this.$route.query.slug
      if (slug) {
        const match = (this.pages || []).find(p => p.slug === slug)
        if (match) { await this.selectPage(match) }
        else {
          // If not exists, prefill create modal with slug
          this.createForm.slug = slug
          this.createForm.title = slug
          this.showCreate = true
        }
      }
    },
    displayLabel(key, isHtml=false){
      const slug = (this.currentPage && this.currentPage.slug) || ''
      const map = this.labelMaps[slug] || {}
      const base = map[key] || key
      if (isHtml && !/（HTML）$/.test(base)) return `${base}（HTML）`
      return base
    },
    pageContentKeyFromSlug(slug){
      const s = (slug||'').toLowerCase()
      if (s.includes('privacy')) return 'privacy'
      if (s.includes('legal') || s.includes('transaction')) return 'transaction-law'
      if (s.includes('terms')) return 'terms'
      if (s.includes('company')) return 'company-profile'
      if (s.includes('consult')) return 'cri-consulting'
      if (s.includes('aboutus')) return 'about-institute'
      if (s.includes('about')) return 'about'
      if (s.includes('sitemap')) return 'sitemap'
      if (s.includes('faq')) return 'faq'
      if (s.includes('glossary')) return 'glossary'
      if (s.includes('premium')) return 'premium-membership'
      if (s.includes('standard') && s.includes('membership')) return 'standard-membership'
      if (s.includes('membership')) return 'membership'
      if (s === 'home') return 'home'
      if (s.includes('services')) return 'services'
      return null
    },
    async applyPrettyTitles(){
      const list = Array.isArray(this.pages)? this.pages : []
      const jobs = list.map(async (p)=>{
        const key = this.pageContentKeyFromSlug(p.slug)
        if (!key) return
        try{
          const r = await apiClient.adminGetPageContent(key)
          const page = r?.data?.page
          if (!page) return
          const texts = page?.content?.texts || {}
          const title = (typeof texts.page_title === 'string' && texts.page_title.trim()) ? texts.page_title.trim() : (page.title || '')
          if (title) p.title = title
        }catch(_){ /* ignore */ }
      })
      await Promise.all(jobs)
    },
    async selectPage(p){
      const res = await apiClient.getCmsPage(p.id)
      if (res.success){
        this.currentPage = res.data
        // very small mapping to two demo sections: hero (sort 10) and rich (sort 20)
        const secs = (res.data.sections||[])
        const hero = secs.find(s=>s.sort===10) || { id: 'hero', sort: 10, component_type:'Hero', props_json:{ title: '' } }
        const kv = secs.find(s=>s.sort===15) || { id: 'kv', sort: 15, component_type:'KV', props_json:{ image_id:'', ext:'' } }
        const rich = secs.find(s=>s.sort===20) || { id: 'rich', sort: 20, component_type:'RichText', props_json:{ html: '' } }
        this.hero = { title: (hero.props_json&&hero.props_json.title)||'' }
        this.kv = { id: (kv.props_json&&kv.props_json.image_id)||'', ext:(kv.props_json&&kv.props_json.ext)||'', previewUrl: this.kvPreviewFromProps((kv.props_json||{})) }
        this.richText = { html: (rich.props_json&&rich.props_json.html)||'' }
        this.collectWarnings([hero, rich])
        // 推奨のPageContentキーを推定
        const slug = (this.currentPage.slug || '').toLowerCase()
        if (slug.includes('privacy')) this.pageContentKey = 'privacy'
        else if (slug.includes('legal') || slug.includes('transaction')) this.pageContentKey = 'transaction-law'
        else if (slug.includes('terms')) this.pageContentKey = 'terms'
        else if (slug.includes('company')) this.pageContentKey = 'company-profile'
        else if (slug.includes('consult')) this.pageContentKey = 'cri-consulting'
        else if (slug.includes('aboutus')) this.pageContentKey = 'about-institute'
        else if (slug.includes('about')) this.pageContentKey = 'about'
        else if (slug.includes('sitemap')) this.pageContentKey = 'sitemap'
        else if (slug.includes('faq')) this.pageContentKey = 'faq'
        else if (slug.includes('glossary')) this.pageContentKey = 'glossary'
        else if (slug.includes('premium')) this.pageContentKey = 'premium-membership'
        else if (slug.includes('standard') && slug.includes('membership')) this.pageContentKey = 'standard-membership'
        else if (slug.includes('membership')) this.pageContentKey = 'membership'
        else if (slug === 'home') this.pageContentKey = 'home'
        else if (slug.includes('services')) this.pageContentKey = 'services'
        // プレビュー機能は撤去

        // 既存テキストの読み込み
        try {
          // 切替時に汎用フィールドを初期化（前ページのキーが残らないように）
          this.genericTexts = {}
          this.genericHtmls = {}
        const page = await apiClient.adminGetPageContent(this.pageContentKey)
        const content = page?.data?.page?.content || {}
          const texts = (content && typeof content === 'object' && content.texts && typeof content.texts === 'object') ? content.texts : {}
        const htmls = (content && typeof content === 'object' && content.htmls && typeof content.htmls === 'object') ? content.htmls : {}
        // images map → pageImages
        const imgs = (content && typeof content === 'object' && content.images && typeof content.images === 'object') ? content.images : {}
        this.pageImages = Object.keys(imgs).map(k => {
          const v = imgs[k]
          return { key: k, url: (typeof v === 'string') ? v : (v?.url || ''), filename: (typeof v === 'object' ? (v.filename || '') : '') }
        })
          // Reset minimal headings
          if (this.pageContentKey === 'privacy') {
            // 既存のprivacyTextsにAPIの全キーをマージ
            this.privacyTexts = { ...(this.privacyTexts || {}), ...(texts || {}) }
            if (!this.privacyTexts.page_title) this.privacyTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'terms') {
            // terms: texts/htmls ともに全キーをそのままマージ
            this.termsTexts = { ...(this.termsTexts || {}), ...(texts || {}) }
            this.termsHtmls = { ...(this.termsHtmls || {}), ...(htmls || {}) }
            if (!this.termsTexts.page_title) this.termsTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'transaction-law') {
            // 特商法: texts/htmls ともに全キーをそのままマージ
            this.tlTexts = { ...(this.tlTexts || {}), ...(texts || {}) }
            this.tlHtmls = { ...(this.tlHtmls || {}), ...(htmls || {}) }
            if (!this.tlTexts.page_title) this.tlTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'company-profile') {
            this.companyTexts = { ...(this.companyTexts || {}), ...(texts || {}) }
            this.companyHtmls = { ...(this.companyHtmls || {}), ...(htmls || {}) }
            // history
            this.companyHistory = Array.isArray(content?.history) ? content.history.map(h => ({
              year: typeof h?.year === 'string' ? h.year : '',
              date: typeof h?.date === 'string' ? h.date : '',
              body: typeof h?.body === 'string' ? h.body : (typeof h?.title === 'string' ? h.title : '')
            })) : []
            if (!this.companyTexts.page_title) this.companyTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'cri-consulting') {
            this.consultingTexts = { ...(this.consultingTexts || {}), ...(texts || {}) }
            this.consultingHtmls = { ...(this.consultingHtmls || {}), ...(htmls || {}) }
            if (!this.consultingTexts.page_title) this.consultingTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'about-institute') {
            this.aboutTexts = { ...(this.aboutTexts || {}), ...(texts || {}) }
            this.aboutHtmls = { ...(this.aboutHtmls || {}), ...(htmls || {}) }
            if (!this.aboutTexts.page_title) this.aboutTexts.page_title = this.currentPage.title || ''
          } else if (this.pageContentKey === 'glossary') {
            // Glossary: texts/htmls はそのまま、items をロード
            this.genericTexts = {}
            this.genericHtmls = {}
            this.glossaryItems = Array.isArray(content?.items) ? content.items.map(it => ({
              term: typeof it?.term === 'string' ? it.term : (typeof it?.title === 'string' ? it.title : ''),
              category: typeof it?.category === 'string' ? it.category : '',
              definition: typeof it?.definition === 'string' ? it.definition : (typeof it?.content === 'string' ? it.content : '')
            })) : []
          } else if (this.pageContentKey === 'faq') {
            // FAQ: textsはカテゴリ名など。faqs 配列をロード
            this.genericTexts = { ...(texts || {}) }
            this.genericHtmls = { ...(htmls || {}) }
            const list = Array.isArray(content?.faqs) ? content.faqs : []
            this.faqItems = list.map((it, idx) => ({
              category: typeof it?.category === 'string' ? it.category : 'all',
              question: typeof it?.question === 'string' ? it.question : '',
              answer: typeof it?.answer === 'string' ? it.answer : '',
              tags: Array.isArray(it?.tags) ? it.tags : [],
              _id: (typeof it?._id === 'number' || typeof it?._id === 'string') ? it._id : idx
            }))
          } else {
            // フォールバック: 任意ページの全texts/htmlsを編集（置き換え）
            this.genericTexts = { ...(texts || {}) }
            this.genericHtmls = { ...(htmls || {}) }
          }
        } catch(_) { /* noop */ }
      }
    },
    triggerReplace(idx){
      const r = this.$refs[`replace_${idx}`]
      if (r && r[0] && typeof r[0].click === 'function') r[0].click()
      else if (r && typeof r.click === 'function') r.click()
    },
    async onReplacePageImage(idx, e){
      try {
        const file = (e.target.files && e.target.files[0]) || null
        if (!file) return
        const item = this.pageImages[idx]
        if (!item || !this.pageContentKey) return
        const res = await apiClient.adminReplacePageImage(this.pageContentKey, item.key, file)
        if (res && res.success !== false) {
          // refresh current images list
          try {
            const r = await apiClient.adminGetPageContent(this.pageContentKey)
            const content = r?.data?.page?.content || {}
            const imgs = (content && typeof content === 'object' && content.images && typeof content.images === 'object') ? content.images : {}
            this.pageImages = Object.keys(imgs).map(k => {
              const v = imgs[k]
              return { key: k, url: (typeof v === 'string') ? v : (v?.url || ''), filename: (typeof v === 'object' ? (v.filename || '') : '') }
            })
          } catch(_) {}
          alert('画像を差し替えました')
        } else {
          alert('差し替えに失敗しました')
        }
      } catch(_) { alert('差し替えに失敗しました') }
    },
    triggerAddNew(){
      if (!this.newImageKey) { alert('新規キーを入力してください'); return }
      if (this.$refs.newImageInput && typeof this.$refs.newImageInput.click === 'function') this.$refs.newImageInput.click()
    },
    async onAddNewPageImage(e){
      try {
        const file = (e.target.files && e.target.files[0]) || null
        if (!file || !this.newImageKey || !this.pageContentKey) return
        const res = await apiClient.adminReplacePageImage(this.pageContentKey, this.newImageKey, file)
        if (res && res.success !== false) {
          // push to list
          try {
            const r = await apiClient.adminGetPageContent(this.pageContentKey)
            const content = r?.data?.page?.content || {}
            const imgs = (content && typeof content === 'object' && content.images && typeof content.images === 'object') ? content.images : {}
            this.pageImages = Object.keys(imgs).map(k => {
              const v = imgs[k]
              return { key: k, url: (typeof v === 'string') ? v : (v?.url || ''), filename: (typeof v === 'object' ? (v.filename || '') : '') }
            })
          } catch(_) {}
          this.newImageKey = ''
          alert('画像を追加しました')
        } else {
          alert('追加に失敗しました')
        }
      } catch(_) { alert('追加に失敗しました') }
    },
    kvPreviewFromProps(props){
      if (!props || !props.image_id || !props.ext) return ''
      return getApiUrl(`/api/public/m/${encodeURIComponent(props.image_id)}/md.${encodeURIComponent(props.ext)}`)
    },
    collectWarnings(sections){
      const warn = []
      const expected = {
        'Hero': new Set(['title']),
        'RichText': new Set(['html'])
      }
      for (const s of sections){
        if (!s || !s.component_type) continue
        const props = (s.props_json && typeof s.props_json === 'object') ? Object.keys(s.props_json) : []
        const ex = expected[s.component_type]
        if (ex){
          for (const k of props){ if (!ex.has(k)) warn.push(`${s.component_type}: 未対応キー「${k}」`) }
        } else {
          warn.push(`未対応ブロック: ${s.component_type}`)
        }
      }
      this.warnings = warn
    },
    renderPreviewHtml(){
      const h = this.hero.title ? `<section><h1>${this.escape(this.hero.title)}</h1></section>` : ''
      const r = this.richText.html ? `<section>${this.richText.html}</section>` : ''
      return `<!doctype html><html><head><meta charset='utf-8'><style>body{font-family:sans-serif;padding:16px;}section{margin:16px 0;}h1{font-size:24px;}</style></head><body>${h}${r}</body></html>`
    },
    escape(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') },
    async savePageMeta(){ if (!this.currentPage) return; await apiClient.updateCmsPage(this.currentPage.id, { title: this.currentPage.title }) },
    async saveHero(){ if (!this.currentPage) return; await apiClient.upsertCmsSection(this.currentPage.id, 'hero', { sort:10, component_type:'Hero', props_json:{ title: this.hero.title }, status:'draft' }) },
    async saveRich(){ if (!this.currentPage) return; await apiClient.upsertCmsSection(this.currentPage.id, 'rich', { sort:20, component_type:'RichText', props_json:{ html: this.richText.html }, status:'draft' }) },
    async syncCompanyPageContentIfApplicable(){
      try {
        const slug = (this.currentPage && this.currentPage.slug || '').toLowerCase()
        if (!slug.includes('company')) return
        // Bridge: push company texts/htmls/history to legacy PageContent (company-profile)
        const hist = Array.isArray(this.companyHistory) ? this.companyHistory
          .map(h => ({ year: String(h.year||'').trim(), date: String(h.date||'').trim(), body: String(h.body||'').trim() }))
          .filter(h => h.year || h.date || h.body) : []
        const patch = { content: {} }
        if (this.companyTexts && Object.keys(this.companyTexts).length) patch.content.texts = { ...this.companyTexts }
        if (this.companyHtmls && Object.keys(this.companyHtmls).length) patch.content.htmls = { ...this.companyHtmls }
        patch.content.history = hist
        // Also mark published to make it visible on public API
        const payload = { ...patch, is_published: true }
        await apiClient.adminUpdatePageContent('company-profile', payload)
      } catch (_) { /* non-blocking */ }
    },
    async publish(){
      if (!this.currentPage) return
      // Bridge legacy PageContent before publishing v2 (non-blocking)
      try { await this.syncCompanyPageContentIfApplicable() } catch(_) {}
      const res = await apiClient.publishCmsPage(this.currentPage.id)
      if (res.success) {
        try { await apiClient.setCmsOverride({ slug: this.currentPage.slug, page_id: this.currentPage.id, enabled: true }) } catch(_){ /* ignore */ }
        alert('公開しました（オーバーライドON）')
      }
    },
    async unpublish(){
      if (!this.currentPage) return
      try {
        const res = await apiClient.setCmsOverride({ slug: this.currentPage.slug, page_id: this.currentPage.id, enabled: false })
        if (res.success) alert('公開を停止しました（オーバーライドOFF）')
      } catch(_){ alert('公開停止に失敗しました') }
    },
    async issuePreview(){
      if (!this.currentPage) return
      try{
        const tok = await apiClient.issueCmsPreviewToken(this.currentPage.id)
        if (tok.success) {
          const t = tok.data.token
          const slug = tok.data.slug
          this.previewUrl = getApiUrl(`/api/public/pages-v2/${encodeURIComponent(slug)}/preview?token=${encodeURIComponent(t)}`)
          alert('プレビューリンクを作成しました。開くボタンで確認できます。')
        }
      }catch(_){ alert('プレビューリンクの作成に失敗しました') }
    },
    selectKvFile(){ this.$refs.kvInput && this.$refs.kvInput.click() },
    async onKvSelected(e){
      const f = (e.target.files && e.target.files[0]) || null
      if (!f || !this.currentPage) return
      try{
        const up = await apiClient.uploadCmsMedia(f)
        if (up && up.success){
          const id = up.data.id
          const mime = (up.data.mime||'').toLowerCase()
          const ext = mime.includes('png')? 'png' : mime.includes('webp')? 'webp' : mime.includes('gif')? 'gif' : 'jpg'
          await apiClient.upsertCmsSection(this.currentPage.id, 'kv', { sort:15, component_type:'KV', props_json:{ image_id:id, ext }, status:'draft' })
          this.kv = { id, ext, previewUrl: getApiUrl(`/api/public/m/${encodeURIComponent(id)}/md.${encodeURIComponent(ext)}`) }
        } else {
          alert('画像アップロードに失敗しました')
        }
      } catch(_){ alert('画像アップロードに失敗しました') }
    },
    selectContentImage(){ this.$refs.contentImgInput && this.$refs.contentImgInput.click() },
    async onContentImageSelected(e){
      const f = (e.target.files && e.target.files[0]) || null
      if (!f || !this.currentPage) return
      try{
        const up = await apiClient.uploadCmsMedia(f)
        if (up && up.success){
          const id = up.data.id
          const mime = (up.data.mime||'').toLowerCase()
          const ext = mime.includes('png')? 'png' : mime.includes('webp')? 'webp' : mime.includes('gif')? 'gif' : 'jpg'
          const url = getApiUrl(`/api/public/m/${encodeURIComponent(id)}/md.${encodeURIComponent(ext)}`)
          this.lastContentImgUrl = url
        } else {
          alert('画像アップロードに失敗しました')
        }
      } catch(_){ alert('画像アップロードに失敗しました') }
    },
    getImageUrlByKey(key){
      try {
        const item = (this.pageImages || []).find(it => it.key === key)
        return item ? (item.url || '') : ''
      } catch(_) { return '' }
    },
    triggerCompanyImageUpload(key){
      const refName = `img_${key}`
      const el = this.$refs[refName]
      if (el && el[0] && typeof el[0].click === 'function') el[0].click()
      else if (el && typeof el.click === 'function') el.click()
    },
    async onCompanyImageSelected(key, e){
      try {
        const file = (e.target.files && e.target.files[0]) || null
        if (!file || !this.pageContentKey) return
        const res = await apiClient.adminReplacePageImage(this.pageContentKey, key, file)
        if (res && res.success !== false) {
          await this.refreshPageImages()
        } else {
          alert('画像アップロードに失敗しました')
        }
      } catch(_) { alert('画像アップロードに失敗しました') }
    },
    async refreshPageImages(){
      try {
        const r = await apiClient.adminGetPageContent(this.pageContentKey)
        const content = r?.data?.page?.content || {}
        const imgs = (content && typeof content === 'object' && content.images && typeof content.images === 'object') ? content.images : {}
        this.pageImages = Object.keys(imgs).map(k => {
          const v = imgs[k]
          return { key: k, url: (typeof v === 'string') ? v : (v?.url || ''), filename: (typeof v === 'object' ? (v.filename || '') : '') }
        })
      } catch(_) {}
    },
    insertLastContentImage(){
      if (!this.lastContentImgUrl) return
      const html = this.richText.html || ''
      this.richText.html = `${html}\n<p><img src="${this.lastContentImgUrl}" alt=""></p>`
      this.lastContentImgUrl = ''
    },
    async importExistingPrivacy(){
      try {
        // 候補キーを順に探索（UIで指定→ privacy → privacy-poricy → privacy-policy → privacy poricy）
        const candidates = [
          this.pageContentKey,
          // common fallbacks
          'terms', 'transaction-law', 'company-profile', 'consulting', 'about-institute',
          'about', 'sitemap', 'faq', 'glossary', 'membership', 'home', 'services',
          'privacy', 'privacy-poricy', 'privacy-policy', 'privacy poricy'
        ]
        let foundKey = null
        let res = null
        for (const k of candidates) {
          try {
            const r = await apiClient.adminGetPageContent(k)
            if (r && r.success && r.data && r.data.page) { res = r; foundKey = k; break }
          } catch(_) { /* try next */ }
        }
        // 無ければ既定キーで初期作成
        if (!res || !foundKey) {
          foundKey = this.pageContentKey
          const defaultTitle = foundKey === 'terms' ? '利用規約' : (foundKey === 'transaction-law' ? '特定商取引法に関する表記' : 'プライバシーポリシー')
          const defaultTexts = foundKey === 'terms' ? { page_title: '利用規約', page_subtitle: 'terms of service' } : (foundKey === 'transaction-law' ? { page_title: '特定商取引法に関する表記', page_subtitle: 'transaction law' } : { page_title: 'プライバシーポリシー', page_subtitle: 'privacy policy', intro: '' })
          await apiClient.post('/api/admin/pages', {
            page_key: foundKey,
            title: defaultTitle,
            content: { html: '', texts: defaultTexts },
            is_published: true
          })
          res = await apiClient.adminGetPageContent(foundKey)
        }
        // 採用キーを記録
        this.pageContentKey = foundKey
        const content = res?.data?.page?.content || {}
        const texts = content.texts || {}
        // Prefer content.html; fallback to content.htmls.body if html is empty
        const htmls = (content && content.htmls) || {}
        const bodyHtml = (typeof htmls?.body === 'string') ? htmls.body : ''
        const html = (typeof content?.html === 'string' && content.html.trim()) ? content.html : bodyHtml
        if (typeof html === 'string') {
          this.richText.html = html
        }
        // set known fields if present (per page)
        if (foundKey === 'privacy') {
          this.privacyTexts = { ...(this.privacyTexts || {}), ...(texts || {}) }
        } else if (foundKey === 'terms') {
          this.termsTexts = { ...(this.termsTexts || {}), ...(texts || {}) }
          this.termsHtmls = { ...(this.termsHtmls || {}), ...(htmls || {}) }
        } else if (foundKey === 'transaction-law') {
          this.tlTexts = { ...(this.tlTexts || {}), ...(texts || {}) }
          this.tlHtmls = { ...(this.tlHtmls || {}), ...(htmls || {}) }
        } else if (foundKey === 'company-profile') {
          this.companyTexts = { ...(this.companyTexts || {}), ...(texts || {}) }
          this.companyHtmls = { ...(this.companyHtmls || {}), ...(htmls || {}) }
          this.companyHistory = Array.isArray(content?.history) ? content.history.map(h => ({
            year: typeof h?.year === 'string' ? h.year : '',
            date: typeof h?.date === 'string' ? h.date : '',
            body: typeof h?.body === 'string' ? h.body : (typeof h?.title === 'string' ? h.title : '')
          })) : []
        } else if (foundKey === 'cri-consulting') {
          this.consultingTexts = { ...(this.consultingTexts || {}), ...(texts || {}) }
          this.consultingHtmls = { ...(this.consultingHtmls || {}), ...(htmls || {}) }
        } else if (foundKey === 'about-institute') {
          this.aboutTexts = { ...(this.aboutTexts || {}), ...(texts || {}) }
          this.aboutHtmls = { ...(this.aboutHtmls || {}), ...(htmls || {}) }
        } else if (foundKey === 'glossary') {
          this.glossaryItems = Array.isArray(content?.items) ? content.items.map(it => ({
            term: typeof it?.term === 'string' ? it.term : (typeof it?.title === 'string' ? it.title : ''),
            category: typeof it?.category === 'string' ? it.category : '',
            definition: typeof it?.definition === 'string' ? it.definition : (typeof it?.content === 'string' ? it.content : '')
          })) : []
        } else if (foundKey === 'faq') {
          this.genericTexts = { ...(texts || {}) }
          this.genericHtmls = { ...(htmls || {}) }
          const list = Array.isArray(content?.faqs) ? content.faqs : []
          this.faqItems = list.map((it, idx) => ({
            category: typeof it?.category === 'string' ? it.category : 'all',
            question: typeof it?.question === 'string' ? it.question : '',
            answer: typeof it?.answer === 'string' ? it.answer : '',
            tags: Array.isArray(it?.tags) ? it.tags : [],
            _id: (typeof it?._id === 'number' || typeof it?._id === 'string') ? it._id : idx
          }))
        } else {
          // generic: 置き換え
          this.genericTexts = { ...(texts || {}) }
          this.genericHtmls = { ...(htmls || {}) }
        }
        alert('既存の文言を取り込みました')
      } catch (e) {
        console.warn('importExistingPrivacy failed', e)
        alert('取り込みに失敗しました')
      }
    },
    async syncRichToPageContentHtml(){
      try {
        const html = this.richText.html || ''
        // Sync to both html and htmls.body for backward compatibility
        const patch = { content: { html, htmls: { body: html } } }
        const res = await apiClient.adminUpdatePageContent(this.pageContentKey, patch)
        if (res) alert('PageContentに本文を同期しました')
      } catch (e) {
        alert('同期に失敗しました')
      }
    },
    async savePrivacyTexts(){
      try {
        let patch = { content: {} }
        if (this.pageContentKey === 'privacy') {
          patch.content.texts = { ...this.privacyTexts }
        } else if (this.pageContentKey === 'terms') {
          patch.content.texts = { ...this.termsTexts }
          patch.content.htmls = { ...this.termsHtmls }
        } else if (this.pageContentKey === 'transaction-law') {
          patch.content.texts = { ...this.tlTexts }
          patch.content.htmls = { ...this.tlHtmls }
        } else if (this.pageContentKey === 'company-profile') {
          patch.content.texts = { ...this.companyTexts }
          patch.content.htmls = { ...this.companyHtmls }
          const hist = Array.isArray(this.companyHistory) ? this.companyHistory
            .map(h => ({ year: String(h.year||'').trim(), date: String(h.date||'').trim(), body: String(h.body||'').trim() }))
            .filter(h => h.year || h.date || h.body) : []
          patch.content.history = hist
        } else if (this.pageContentKey === 'cri-consulting') {
          patch.content.texts = { ...this.consultingTexts }
          patch.content.htmls = { ...this.consultingHtmls }
        } else if (this.pageContentKey === 'about-institute') {
          patch.content.texts = { ...this.aboutTexts }
          patch.content.htmls = { ...this.aboutHtmls }
        } else if (this.pageContentKey === 'glossary') {
          // texts/htmls は既存どおり（intro等）。items も保存
          if (Object.keys(this.genericTexts||{}).length) patch.content.texts = { ...this.genericTexts }
          if (Object.keys(this.genericHtmls||{}).length) patch.content.htmls = { ...this.genericHtmls }
          // normalize items
          const items = Array.isArray(this.glossaryItems) ? this.glossaryItems
            .map(it => ({ term: String(it.term||'').trim(), category: String(it.category||'').trim(), definition: String(it.definition||'').trim() }))
            .filter(it => it.term && it.definition) : []
          patch.content.items = items
        } else if (this.pageContentKey === 'faq') {
          // FAQ: texts（カテゴリ名など）と faqs 配列を保存
          if (Object.keys(this.genericTexts||{}).length) patch.content.texts = { ...this.genericTexts }
          if (Object.keys(this.genericHtmls||{}).length) patch.content.htmls = { ...this.genericHtmls }
          const faqs = Array.isArray(this.faqItems) ? this.faqItems.map((it, idx) => ({
            category: String((it.category||'all')).trim() || 'all',
            question: String(it.question||'').trim(),
            answer: String(it.answer||'').trim(),
            tags: Array.isArray(it.tags) ? it.tags.map(t=>String(t).trim()).filter(Boolean) : [],
            _id: (typeof it._id === 'number' || typeof it._id === 'string') ? it._id : idx
          })).filter(it => it.question || it.answer) : []
          patch.content.faqs = faqs
        } else {
          // generic fallback: 動的に集めたtexts/htmlsを保存
          const hasGeneric = (this.genericTexts && Object.keys(this.genericTexts).length) || (this.genericHtmls && Object.keys(this.genericHtmls).length)
          if (hasGeneric) {
            if (this.genericTexts && Object.keys(this.genericTexts).length) patch.content.texts = { ...this.genericTexts }
            if (this.genericHtmls && Object.keys(this.genericHtmls).length) patch.content.htmls = { ...this.genericHtmls }
          } else {
            // last resort
            patch.content.texts = { ...this.privacyTexts }
          }
        }
        const res = await apiClient.adminUpdatePageContent(this.pageContentKey, patch)
        if (res) alert('保存しました')
      } catch(_) { alert('保存に失敗しました') }
    },
    openCreate(){ this.showCreate = true },
    async create(){
      if (!this.createForm.slug || !this.createForm.title) return
      const res = await apiClient.createCmsPage({ ...this.createForm })
      if (res.success){ this.showCreate=false; this.createForm={slug:'', title:''}; await this.loadPages(); this.selectPage(res.data) }
    }
  }
}
</script>

  <style scoped>
  .cms{ display:flex; gap:0; min-height: calc(100vh - 140px); background:#fff; border-radius:8px; overflow:hidden; }
  .pane{ border-right:1px solid #eee; }
  .left{ width:280px; }
  .center{ flex:1; padding:16px; }
  .right{ width:360px; }
.toolbar{ display:flex; gap:8px; padding:10px; border-bottom:1px solid #eee; }
.list{ overflow:auto; height: calc(100% - 50px); }
.item{ padding:10px 12px; border-bottom:1px solid #f4f4f4; cursor:pointer; }
.item.active{ background:#fff2f4; }
.title{ font-weight:600; }
.slug{ color:#777; font-size:12px; }
.editor-form{ max-width: 860px; margin: 0 auto; }
.field{ margin-bottom:12px; display:flex; flex-direction:column; gap:6px; }
.input, .textarea{ border:1px solid #ddd; border-radius:6px; padding:8px 10px; }
.btn{ background:#1A1A1A; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer; }
.btn.primary{ background:#DA5761; }
.empty{ padding:16px; color:#777; }
.modal{ position:fixed; inset:0; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; }
.modal-inner{ background:#fff; border-radius:8px; padding:16px; width:360px; display:flex; flex-direction:column; gap:10px; }
.actions{ display:flex; justify-content:flex-end; }
  .actions-row{ display:flex; gap:8px; justify-content:center; padding-top:8px; }
  .section-title{ background:#e6f0ff; color:#1a3a7c; padding:6px 10px; border-left:4px solid #2d5bd1; margin:10px 0; font-weight:600; }
  .kv-uploader{ border:1px dashed #bbb; border-radius:8px; height:160px; display:flex; align-items:center; justify-content:center; background:#fafafa; cursor:pointer; }
  .kv-placeholder{ display:flex; flex-direction:column; align-items:center; color:#666; gap:6px; }
  .kv-icon{ font-size:22px; }
  .kv-preview{ width:100%; height:100%; background-size:cover; background-position:center; border-radius:8px; }
  .help{ color:#777; font-size:12px; }
  /* Preview panel removed */
  .page-image-row{ display:flex; gap:12px; align-items:center; border:1px solid #eee; border-radius:8px; padding:10px; margin-bottom:8px; background:#fafafa; }
  .img-preview{ width:120px; height:80px; background:#fff; border:1px solid #eee; display:flex; align-items:center; justify-content:center; }
  .img-preview img{ max-width:100%; max-height:100%; object-fit:contain; }
  .img-meta{ display:flex; flex-direction:column; gap:6px; }
  .img-key{ font-weight:600; }
  .img-file{ color:#777; font-size:12px; }
  </style>
