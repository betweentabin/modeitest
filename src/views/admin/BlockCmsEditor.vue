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
          <template v-if="currentPage && currentPage.slug==='company'">
            <div class="field" v-for="(val, key) in companyTexts" :key="`company-${key}`">
              <label>{{ key }}</label>
              <input v-model="companyTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in companyHtmls" :key="`company-html-${key}`">
              <label>{{ key }}（HTML）</label>
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
          <template v-if="currentPage && currentPage.slug==='cri-consulting'">
            <div class="field" v-for="(val, key) in consultingTexts" :key="`consult-${key}`">
              <label>{{ key }}</label>
              <input v-model="consultingTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in consultingHtmls" :key="`consult-html-${key}`">
              <label>{{ key }}（HTML）</label>
              <textarea v-model="consultingHtmls[key]" class="textarea" rows="3"></textarea>
            </div>
          </template>
          <template v-if="currentPage && currentPage.slug==='aboutus'">
            <div class="field" v-for="(val, key) in aboutTexts" :key="`about-${key}`">
              <label>{{ key }}</label>
              <input v-model="aboutTexts[key]" class="input" />
            </div>
            <div class="field" v-for="(val, key) in aboutHtmls" :key="`about-html-${key}`">
              <label>{{ key }}（HTML）</label>
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

          <!-- フォールバック: 汎用のtexts/htmlsエディタ（除外ページ以外） -->
          <template v-if="currentPage && showGenericEditor">
            <div class="section-title">子コンポーネント文言（基本）</div>
            <div class="field" v-for="(val, key) in genericTexts" :key="`gtext-${key}`">
              <label>{{ key }}</label>
              <input v-model="genericTexts[key]" class="input" />
            </div>
            <div class="section-title">セクション別文言（HTML）</div>
            <div class="field" v-for="(val, key) in genericHtmls" :key="`ghtml-${key}`">
              <label>{{ key }}（HTML）</label>
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
      // glossary: 用語リスト（items）の編集
        glossaryItems: [],
        companyHistory: [],
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
    }
  },
  methods: {
    async loadPages(){
      const res = await apiClient.listCmsPages({ search: this.search, per_page: 100 })
      if (res.success) this.pages = res.data.data || []
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
        else if (slug.includes('financial')) this.pageContentKey = 'financial-reports'
        else if (slug === 'home') this.pageContentKey = 'home'
        else if (slug.includes('services')) this.pageContentKey = 'services'
        else if (slug.includes('company')) this.pageContentKey = 'company-profile'
        else if (slug.includes('consult')) this.pageContentKey = 'cri-consulting'
        else if (slug.includes('about')) this.pageContentKey = 'about-institute'

        // 既存テキストの読み込み
        try {
          // 切替時に汎用フィールドを初期化（前ページのキーが残らないように）
          this.genericTexts = {}
          this.genericHtmls = {}
          const page = await apiClient.adminGetPageContent(this.pageContentKey)
          const content = page?.data?.page?.content || {}
          const texts = (content && typeof content === 'object' && content.texts && typeof content.texts === 'object') ? content.texts : {}
          const htmls = (content && typeof content === 'object' && content.htmls && typeof content.htmls === 'object') ? content.htmls : {}
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
          } else {
            // フォールバック: 任意ページの全texts/htmlsを編集（置き換え）
            this.genericTexts = { ...(texts || {}) }
            this.genericHtmls = { ...(htmls || {}) }
          }
        } catch(_) { /* noop */ }
      }
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
    async publish(){
      if (!this.currentPage) return
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
          'about', 'sitemap', 'faq', 'glossary', 'membership', 'financial-reports', 'home', 'services',
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
</style>
