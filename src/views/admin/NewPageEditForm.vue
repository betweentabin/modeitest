<template>
  <AdminLayout>
    <div class="dashboard">
      <!-- ページヘッダー -->
      <div class="page-header">
        <div class="header-left">
          <button @click="goBack" class="back-btn">
            ← ダッシュボードに戻る
          </button>
          <h1 class="page-title">{{ isNew ? '新規ページ作成' : 'ページ編集' }}</h1>
        </div>
        <div class="header-actions">
          <button @click="handleLogout" class="logout-btn">ログアウト</button>
        </div>
      </div>

      <!-- フォームコンテナ -->
      <div class="form-container">
        <div v-if="loading" class="loading">読み込み中...</div>
        <div v-else-if="error && !isNew" class="error-container">
          <div class="error-message">{{ error }}</div>
        </div>
        <div v-else class="form-content">
          <form @submit.prevent="handleSubmit" class="edit-form">
            <!-- ページキー -->
            <div class="form-section">
              <div class="form-group">
                <label for="page_key" class="form-label">
                  ページキー <span class="required">*</span>
                </label>
                <input
                  id="page_key"
                  v-model="formData.page_key"
                  type="text"
                  :disabled="!isNew"
                  required
                  class="form-input"
                  :class="{ disabled: !isNew }"
                  placeholder="例: about, services, contact"
                />
                <p class="form-help">
                  {{ isNew ? 'URLの一部になります（例: /about）' : 'ページキーは編集できません' }}
                </p>
              </div>
            </div>

            <!-- タイトル -->
            <div class="form-section">
              <div class="form-group">
                <label for="title" class="form-label">
                  ページタイトル <span class="required">*</span>
                </label>
                <input
                  id="title"
                  v-model="formData.title"
                  type="text"
                  required
                  class="form-input"
                  placeholder="ページのタイトルを入力してください"
                />
              </div>
            </div>

            <!-- 画像管理 -->
            <div class="form-section">
              <h3 class="section-title">画像管理</h3>
              <div class="image-management">
                <div v-if="!isNew && formData.images && formData.images.length > 0" class="image-list">
                  <div v-for="(image, index) in formData.images" :key="index" class="image-item">
                    <div class="image-preview">
                      <img :src="image.url" :alt="image.alt || '画像'" class="preview-img" />
                    </div>
                    <div class="image-details">
                      <div class="image-info">
                        <div class="image-name">{{ image.alt || `画像 ${index + 1}` }}</div>
                        <div class="image-path">{{ image.url }}</div>
                      </div>
                      <div class="image-actions">
                        <button 
                          type="button" 
                          @click="editImage(index)" 
                          class="image-btn edit-image-btn"
                        >
                          編集
                        </button>
                        <button 
                          type="button" 
                          @click="deleteImage(index)" 
                          class="image-btn delete-image-btn"
                        >
                          削除
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div v-else class="no-images">
                  <p>画像がまだ追加されていません</p>
                </div>
                
                <div class="add-image-section">
                  <button 
                    type="button" 
                    @click="showImageUploadModal = true" 
                    class="add-image-btn"
                  >
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                    </svg>
                    画像を追加
                  </button>
                </div>
                
                <!-- 画像アップロードモーダル -->
                <div v-if="showImageUploadModal" class="modal-overlay">
                  <div class="modal-container">
                    <div class="modal-header">
                      <h3>画像を追加</h3>
                      <button @click="showImageUploadModal = false" class="close-modal">×</button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label class="form-label">画像を選択</label>
                        <input 
                          type="file" 
                          @change="handleImageSelect" 
                          accept="image/*" 
                          class="file-input"
                          ref="fileInput"
                        />
                      </div>
                      
                      <div v-if="selectedImage" class="image-preview-container">
                        <img :src="selectedImagePreview" alt="プレビュー" class="image-preview-large" />
                      </div>
                      
                      <div class="form-group">
                        <label for="image-alt" class="form-label">代替テキスト</label>
                        <input 
                          id="image-alt" 
                          v-model="newImage.alt" 
                          type="text" 
                          class="form-input" 
                          placeholder="画像の説明"
                        />
                      </div>
                      
                      <div class="form-group">
                        <label for="image-description" class="form-label">説明</label>
                        <textarea 
                          id="image-description" 
                          v-model="newImage.description" 
                          class="form-input" 
                          rows="3" 
                          placeholder="画像の詳細な説明"
                        ></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button 
                        @click="showImageUploadModal = false" 
                        class="btn btn-secondary"
                      >
                        キャンセル
                      </button>
                      <button 
                        @click="addImage" 
                        class="btn btn-primary"
                        :disabled="!selectedImage"
                      >
                        追加
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- コンテンツ -->
            <div class="form-section">
              <h3 class="section-title">コンテンツ</h3>
              <div class="mode-toggle">
                <label><input type="radio" value="wysiwyg" v-model="contentMode" /> エディタ（おすすめ）</label>
                <label><input type="radio" value="html" v-model="contentMode" /> HTML（全文編集）</label>
                <label><input type="radio" value="json" v-model="contentMode" /> JSON</label>
                <label><input type="radio" value="fields" v-model="contentMode" /> Fields（安全なテキスト上書き）</label>
                <label><input type="radio" value="inline" v-model="contentMode" /> ページ風プレビュー（直編集）</label>
                <label><input type="radio" value="live" v-model="contentMode" /> 現在のページそのままプレビュー</label>
              </div>

              <!-- WYSIWYG editor -->
              <div v-if="contentMode==='wysiwyg'" class="form-group">
                <div class="editor-toolbar">
                  <button type="button" class="tb-btn" @click="execCmd('bold')"><b>B</b></button>
                  <button type="button" class="tb-btn" @click="execCmd('italic')"><i>I</i></button>
                  <button type="button" class="tb-btn" @click="execCmd('underline')"><u>U</u></button>
                  <span class="sep" />
                  <button type="button" class="tb-btn" @click="formatBlock('H1')">H1</button>
                  <button type="button" class="tb-btn" @click="formatBlock('H2')">H2</button>
                  <button type="button" class="tb-btn" @click="formatBlock('H3')">H3</button>
                  <span class="sep" />
                  <button type="button" class="tb-btn" @click="execCmd('insertUnorderedList')">• List</button>
                  <button type="button" class="tb-btn" @click="execCmd('insertOrderedList')">1. List</button>
                  <span class="sep" />
                  <button type="button" class="tb-btn" @click="insertLink()">Link</button>
                  <button type="button" class="tb-btn" @click="execCmd('removeFormat')">Clear</button>
                  <div class="flex-spacer" />
                  <label class="preview-toggle"><input type="checkbox" v-model="showPreview" /> プレビュー</label>
                </div>
                <div :class="['editor-split', showPreview ? 'with-preview' : '']">
                  <div 
                    class="wysiwyg-editor" 
                    ref="wysiwyg"
                    contenteditable
                    @input="onWysiwygInput"
                    v-html="contentHtml"
                  />
                  <div v-if="showPreview" class="wysiwyg-preview">
                    <div class="preview-inner" v-html="contentHtml"></div>
                  </div>
                </div>
                <p class="form-help">簡易エディタです。装飾は基本的な太字・見出し・リスト・リンクに対応しています。</p>
              </div>

              <div v-if="contentMode==='json'" class="form-group">
                <label for="content" class="form-label">
                  コンテンツ (JSON形式) <span class="required">*</span>
                </label>
                <div class="json-editor-container">
                  <textarea
                    id="content"
                    v-model="contentJson"
                    rows="15"
                    required
                    class="json-editor"
                    :class="{ error: jsonError }"
                    placeholder='{"key": "value", "title": "タイトル", "description": "説明文"}'
                  />
                  <div v-if="jsonError" class="json-error">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zM7 3v4a1 1 0 0 0 2 0V3a1 1 0 0 0-2 0zm1 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                    {{ jsonError }}
                  </div>
                  <div v-else class="json-success">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    JSONフォーマットが正しいです
                  </div>
                </div>
              </div>

              <div v-else-if="contentMode==='html'" class="form-group">
                <label for="content_html" class="form-label">
                  コンテンツ (HTML)
                </label>
                <textarea
                  id="content_html"
                  v-model="contentHtml"
                  rows="18"
                  class="html-editor"
                  placeholder="ここにHTMLを直接入力してください"
                />
                <label class="preview-inline"><input type="checkbox" v-model="showPreview" /> プレビューを表示</label>
                <div v-if="showPreview" class="html-preview" v-html="contentHtml"></div>
                <p class="form-help">危険なスクリプトは入れないでください（管理画面のみで使用、サニタイズは未実装）。</p>
              </div>

              <!-- Inline page-like editor -->
              <div v-else-if="contentMode==='inline'" class="form-group">
                <div class="inline-toolbar">
                  <button type="button" class="tb-btn" @click="execInline('bold')"><b>B</b></button>
                  <button type="button" class="tb-btn" @click="execInline('italic')"><i>I</i></button>
                  <button type="button" class="tb-btn" @click="execInline('underline')"><u>U</u></button>
                  <span class="sep" />
                  <button type="button" class="tb-btn" @click="formatInline('H1')">H1</button>
                  <button type="button" class="tb-btn" @click="formatInline('H2')">H2</button>
                  <button type="button" class="tb-btn" @click="formatInline('P')">P</button>
                  <span class="sep" />
                  <button type="button" class="tb-btn" @click="insertInlineLink()">Link</button>
                  <button type="button" class="tb-btn" @click="execInline('removeFormat')">Clear</button>
                </div>
                <div class="inline-surface">
                  <div class="inline-page">
                    <div class="inline-hero">ページヘッダー領域（プレビュー）</div>
                    <div class="inline-body cms-body">
                      <div 
                        ref="inlineEditor" 
                        class="inline-editor" 
                        contenteditable 
                        v-html="contentHtml"
                        @input="onInlineInput"
                      />
                    </div>
                    <div class="inline-footer">フッター領域（プレビュー）</div>
                  </div>
                </div>
                <p class="form-help">実際のサイト風にレイアウトして、本文をその場で編集できます。保存でこの内容が反映されます。</p>
              </div>
              <!-- Live page preview (actual page in iframe) -->
              <div v-else-if="contentMode==='live'" class="form-group">
              <div class="preview-toolbar">
                <span>プレビューURL: {{ previewUrl }}</span>
                <div class="device-toggle">
                  <label>デバイス:</label>
                  <select v-model="previewDevice" class="device-select" @change="$nextTick(() => refreshPreview())">
                    <option value="desktop">Desktop (1200px)</option>
                    <option value="tablet">Tablet (900px)</option>
                    <option value="mobile">Mobile (375px)</option>
                  </select>
                </div>
                <button type="button" class="btn btn-secondary small" @click="refreshPreview">リロード</button>
              </div>
              <div class="live-preview-wrap">
                <div class="live-preview-frame" :style="{ width: previewWidthPx + 'px' }">
                  <iframe ref="liveFrame" class="live-preview" :src="previewUrl"></iframe>
                </div>
              </div>
                <p class="form-help">このプレビューは実際のページをそのまま表示します。入力内容は即座に反映されます（保存前は閲覧者には見えません）。</p>
              </div>

              <!-- Fields mode: key-value editor for content.texts -->
              <div v-else class="form-group">
                <label class="form-label">
                  テキストフィールド（content.texts）
                </label>
                <div class="fields-guide">
                  <div class="guide-title">使い方（初心者向けの簡単ステップ）</div>
                  <ol>
                    <li>推奨キーを見て、不足があれば「不足キーを追加」を押す</li>
                    <li>各行の「値」に表示したい文言を入力（キーは基本そのままでOK）</li>
                    <li>右側の文字数カウンタを目安に短く整えるとレイアウトが安定します</li>
                  </ol>
                  <div class="guide-actions">
                    <button type="button" class="btn btn-secondary small" @click="reloadFieldsFromJson">JSON→Fieldsに再読込</button>
                  </div>
                </div>
                <div class="recommended-keys" v-if="recommendedKeys.length">
                  <div class="subtitle">推奨キー（クリックで追加/フォーカス）</div>
                  <div class="chips">
                    <button 
                      v-for="rk in recommendedKeys" 
                      :key="rk"
                      type="button"
                      :class="['chip', hasTextKey(rk) ? 'chip-ok' : 'chip-missing']"
                      @click="focusOrAddKey(rk)"
                    >
                      {{ rk }}
                    </button>
                  </div>
                </div>
                <div class="fields-editor">
                  <div class="field-head">
                    <div>キー</div>
                    <div>値</div>
                    <div>文字数</div>
                    <div>操作</div>
                  </div>
                  <div 
                    v-for="(row, idx) in textsEditor" 
                    :key="row._id"
                    :class="['field-row', getKeyLimit(row.key) && (row.value || '').length > getKeyLimit(row.key) ? 'field-row-warning' : '']"
                  >
                    <input
                      v-model="row.key"
                      type="text"
                      class="form-input field-key"
                      :placeholder="getKeyPlaceholder(row.key) || 'キー（例: page_title, lead, cta_primary）'"
                    />
                    <input
                      v-model="row.value"
                      type="text"
                      class="form-input field-value"
                      :placeholder="getKeyPlaceholder(row.key) ? getKeyPlaceholder(row.key) : '値（表示テキスト）'"
                    />
                    <div class="field-hint">
                      <span v-if="getKeyLimit(row.key)" class="counter">{{ (row.value || '').length }}/{{ getKeyLimit(row.key) }}</span>
                      <span v-else class="counter">{{ (row.value || '').length }}</span>
                      <div v-if="getKeyLabel(row.key)" class="key-help">{{ getKeyLabel(row.key) }}：{{ getKeyDesc(row.key) }}</div>
                      <div v-if="getKeyLocation(row.key)" class="key-help">表示箇所：{{ getKeyLocation(row.key) }}</div>
                    </div>
                    <button type="button" class="btn btn-secondary small" @click="removeTextField(idx)">削除</button>
                  </div>
                  <button type="button" class="btn btn-primary" @click="addTextField">+ フィールドを追加</button>
                  <p class="form-help">推奨キー例: page_title, page_subtitle, lead, cta_primary, cta_secondary</p>
                </div>

                <!-- Live Preview (common placements) -->
                <div class="fields-preview">
                  <div class="preview-hero">
                    <div class="preview-hero-inner">
                      <h1 class="pv-title">{{ text('page_title') || 'ページタイトル' }}</h1>
                      <div class="pv-subtitle">{{ text('page_subtitle') || 'sub title' }}</div>
                      <p class="pv-lead">{{ text('lead') || '概要テキストのプレビュー（任意）' }}</p>
                      <div class="pv-cta">
                        <button class="btn btn-primary">{{ text('cta_primary') || 'お問い合わせはコチラ' }}</button>
                        <button class="btn btn-secondary" style="margin-left:8px;">{{ text('cta_secondary') || '入会はコチラ' }}</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Links subsection -->
                <label class="form-label" style="margin-top:20px;">
                  リンクフィールド（content.links）
                </label>
                <div class="fields-editor">
                  <div class="field-head">
                    <div>キー</div>
                    <div>URL（/ または http(s)://）</div>
                    <div>検証</div>
                    <div>操作</div>
                  </div>
                  <div 
                    v-for="(row, idx) in linksEditor" 
                    :key="row._id"
                    :class="['field-row', !isValidLink(row.value) && (row.value||'').length ? 'field-row-warning' : '']"
                  >
                    <input
                      v-model="row.key"
                      type="text"
                      class="form-input field-key"
                      placeholder="キー（例: cta_primary, cta_secondary）"
                    />
                    <input
                      v-model="row.value"
                      type="text"
                      class="form-input field-value"
                      placeholder="例）/contact または https://example.com"
                    />
                    <div class="field-hint">
                      <span class="counter" :style="{color: isValidLink(row.value) || !(row.value||'').length ? '#065f46' : '#b45309'}">{{ isValidLink(row.value) || !(row.value||'').length ? 'OK' : 'URL形式を確認してください' }}</span>
                    </div>
                    <button type="button" class="btn btn-secondary small" @click="removeLinkField(idx)">削除</button>
                  </div>
                  <div class="guide-actions">
                    <button type="button" class="btn btn-secondary small" @click="addMissingLinkKeys">不足キーを追加（cta系）</button>
                    <button type="button" class="btn btn-primary" @click="addLinkField">+ リンクを追加</button>
                  </div>
                  <p class="form-help">安全のため、`/` から始まるサイト内リンクか、`http(s)://` のみ許可</p>
                </div>
              </div>
            </div>

            <!-- メタデータ -->
            <div class="form-section">
              <h3 class="section-title">SEO設定</h3>
              
              <div class="form-group">
                <label for="meta_description" class="form-label">
                  メタディスクリプション
                </label>
                <textarea
                  id="meta_description"
                  v-model="formData.meta_description"
                  rows="3"
                  class="form-input"
                  placeholder="検索結果に表示される説明文（160文字以内推奨）"
                />
                <p class="form-help">
                  {{ formData.meta_description ? formData.meta_description.length : 0 }}/160文字
                </p>
              </div>

              <div class="form-group">
                <label for="meta_keywords" class="form-label">
                  メタキーワード
                </label>
                <input
                  id="meta_keywords"
                  v-model="formData.meta_keywords"
                  type="text"
                  class="form-input"
                  placeholder="キーワード1, キーワード2, キーワード3"
                />
                <p class="form-help">カンマ区切りでキーワードを入力してください</p>
              </div>
            </div>

            <!-- 公開設定 -->
            <div class="form-section">
              <div class="form-group">
                <label class="checkbox-label">
                  <input
                    v-model="formData.is_published"
                    type="checkbox"
                    class="checkbox-input"
                  />
                  <span class="checkbox-custom"></span>
                  <span class="checkbox-text">ページを公開する</span>
                </label>
                <p class="form-help">
                  チェックを外すと、このページは非公開になります
                </p>
              </div>
            </div>

            <!-- エラー・成功メッセージ -->
            <div v-if="submitError" class="message error-message">
              {{ submitError }}
            </div>

            <div v-if="successMessage" class="message success-message">
              {{ successMessage }}
            </div>

            <!-- アクションボタン -->
            <div class="form-actions">
              <button
                type="button"
                @click="goBack"
                class="btn btn-secondary"
              >
                キャンセル
              </button>
              <button
                type="submit"
                :disabled="loading || jsonError || submitLoading"
                class="btn btn-primary"
              >
                {{ submitLoading ? '保存中...' : '保存' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from './AdminLayout.vue'
import mockServer from '@/mockServer'
import axios from 'axios'
import apiClient from '@/services/apiClient.js'

// 推奨キー（ページキーごと）
const RECOMMENDED_KEYS = {
  home: ['page_title', 'lead', 'cta_primary', 'cta_secondary'],
  'economic-statistics': ['page_title', 'page_subtitle', 'cta_primary', 'cta_secondary'],
  publications: ['page_title', 'page_subtitle', 'cta_primary', 'cta_secondary'],
  'financial-reports': ['page_title', 'page_subtitle', 'cta_primary', 'cta_secondary'],
  'economic-indicators': ['page_title', 'page_subtitle'],
  news: ['page_title', 'page_subtitle'],
  // Aboutページ：ご挨拶の本文/署名までCMS化
  about: ['page_title', 'mission_title', 'mission_body', 'message_title', 'message_subtitle', 'message_body', 'message_signature', 'cta_primary'],
  // CompanyProfile：ご挨拶、ミッション、会社概要見出しまで
  'company-profile': ['page_title', 'page_subtitle', 'philosophy_title', 'philosophy_subtitle', 'message_title', 'message_subtitle', 'message_label', 'message_signature', 'mission_title', 'mission_body', 'profile_title', 'profile_subtitle'],
  // Consulting：主要セクションをCMS化
  consulting: ['page_title', 'page_subtitle', 'what_title', 'what_subtitle', 'what_content_subtitle', 'what_content_heading', 'what_content_body', 'duties_title', 'duties_subtitle', 'duties_intro', 'duties_label', 'duties_heading', 'duties_list', 'support_title', 'support_subtitle_en', 'support_intro', 'support_free_title', 'support_paid_title', 'achievements_title', 'achievements_subtitle', 'cta_primary', 'cta_secondary'],
  // About Institute：導入とサービス概要
  'about-institute': ['page_title', 'page_subtitle', 'about_title', 'about_subtitle', 'about_body', 'service_title', 'service_subtitle', 'service1_title', 'service1_desc', 'service1_list', 'service2_title', 'service2_desc', 'service3_title', 'service3_desc', 'cta_primary', 'cta_secondary'],
  terms: [
    'page_title', 'page_subtitle', 'intro',
    'copyright_title', 'copyright_body',
    'link_title', 'link_body',
    'disclaimer_title', 'disclaimer_body',
    'security_title', 'security_body',
    'cookie_title', 'cookie_body',
    'environment_title', 'environment_body',
    'prohibited_title', 'prohibited_body',
    'article8_title', 'article8_body'
  ],
  privacy: ['page_title', 'page_subtitle'],
  faq: ['page_title', 'page_subtitle'],
  'transaction-law': ['page_title', 'page_subtitle']
}

// ソフト上限（超過時に警告）
const TEXT_LIMITS = {
  page_title: 40,
  page_subtitle: 60,
  lead: 120,
  cta_primary: 30,
  cta_secondary: 30,
  mission_title: 40,
  mission_body: 200
}

// 初心者向けのキー説明
const KEY_HELP = {
  page_title: { label: 'ページタイトル', desc: 'ページの大見出しに表示されます', placeholder: '例）経済・調査統計' },
  page_subtitle: { label: 'サブタイトル（英字など）', desc: 'タイトル下に小さく英字等で表示', placeholder: '例）economic statistics' },
  lead: { label: 'リード文', desc: 'ページ冒頭の説明文（任意）', placeholder: 'ページの概要を1〜2文で書きます' },
  cta_primary: { label: 'メインボタン文言', desc: '主ボタンのテキスト', placeholder: '例）お問い合わせはコチラ' },
  cta_secondary: { label: 'サブボタン文言', desc: '副ボタンのテキスト', placeholder: '例）入会はコチラ' },
  form_title: { label: 'フォーム見出し', desc: 'お問い合わせフォーム上部の見出し', placeholder: 'お問い合わせ' },
  mission_title: { label: 'ミッション見出し', desc: '会社/団体紹介の小見出し', placeholder: '産学官金のネットワークを活かした地域創生' },
  mission_body: { label: 'ミッション本文', desc: '紹介の本文', placeholder: '私たちは、〜〜〜' },
  // ご挨拶（共通）
  message_title: { label: 'ご挨拶見出し', desc: 'セクション見出し（例：ご挨拶）', placeholder: 'ご挨拶' },
  message_subtitle: { label: 'ご挨拶英字', desc: '英字の小見出し（例：MESSAGE）', placeholder: 'MESSAGE' },
  message_label: { label: '左側ラベル', desc: 'セクション左側の大きなラベル', placeholder: 'MESSAGE' },
  message_body: { label: 'ご挨拶本文（HTML可）', desc: '複数段落・リンク等も可（安全にサニタイズ表示）', placeholder: '本文を入力' },
  message_signature: { label: 'ご挨拶の署名', desc: '末尾の署名（役職・氏名など）', placeholder: '株式会社〜 代表取締役〜' },
  mission_label: { label: 'ミッション英字', desc: 'ミッションの英字ラベル', placeholder: 'OUR MISSION' },
}

// キーの表示箇所（ページ別）
const KEY_LOCATIONS = {
  'home': {
    page_title: 'ヒーロー大見出し（HomePage）',
    page_subtitle: 'ヒーロー小見出し（HomePage）',
    lead: 'ヒーロー下の説明文（HomePage）',
    cta_primary: '最下部の主ボタン文言（HomePage）',
    cta_secondary: '最下部の副ボタン文言（HomePage）',
  },
  'economic-statistics': {
    page_title: 'ヒーロー・パンくず・見出し（EconomicStatisticsPage）',
    page_subtitle: '英字のサブ見出し（EconomicStatisticsPage）',
    cta_primary: '最下部の主ボタン文言（EconomicStatisticsPage）',
    cta_secondary: '最下部の副ボタン文言（EconomicStatisticsPage）',
  },
  'publications': {
    page_title: 'ヒーロー・パンくず・見出し（PublicationsPublic/Detail）',
    page_subtitle: '英字のサブ見出し（PublicationsPublic/Detail）',
    cta_primary: '下部の主ボタン文言（Detail等）',
    cta_secondary: '下部の副ボタン文言（Detail等）',
  },
  'financial-reports': {
    page_title: 'ヒーロー・パンくず・見出し（FinancialReportPage）',
    page_subtitle: '英字のサブ見出し（FinancialReportPage）',
    cta_primary: '最下部の主ボタン文言',
    cta_secondary: '最下部の副ボタン文言',
  },
  'economic-indicators': {
    page_title: 'ヒーロー・パンくず・見出し（EconomicIndicatorsPage）',
    page_subtitle: '英字のサブ見出し（EconomicIndicatorsPage）',
  },
  'news': {
    page_title: 'ヒーロー・パンくず・見出し（NewsPage）',
    page_subtitle: '英字のサブ見出し（NewsPage）',
  },
  'contact': {
    page_title: 'ヒーロー・パンくず（ContactFormPage）',
    page_subtitle: '英字のサブ見出し（ContactFormPage）',
    form_title: 'フォームの大見出し（ContactFormPage）',
  },
  'company-profile': {
    page_title: 'ヒーロー・パンくず（CompanyProfile）',
    page_subtitle: '英字のサブ見出し（CompanyProfile）',
    philosophy_title: '哲学セクション見出し（CompanyProfile）',
    philosophy_subtitle: '哲学セクション英字（CompanyProfile）',
    message_title: 'ご挨拶セクション見出し（CompanyProfile）',
    message_subtitle: 'ご挨拶セクション英字（CompanyProfile）',
    message_label: '左側ラベル「MESSAGE」',
    message_signature: 'ご挨拶の署名',
    profile_title: '会社概要セクション見出し',
    profile_subtitle: '会社概要セクション英字',
    mission_label: 'ミッション英字（OUR MISSION）',
    mission_title: 'ミッションの見出し',
    mission_body: 'ミッションの本文（HTML可）',
    history_title: '沿革セクション見出し',
    history_subtitle: '沿革セクション英字',
  },
  'privacy': {
    page_title: 'ヒーロー・パンくず・見出し（PrivacyPolicyPage）',
    page_subtitle: '英字のサブ見出し（PrivacyPolicyPage）',
  },
  'faq': {
    page_title: 'ヒーロー・パンくず・見出し（FaqPage）',
    page_subtitle: '英字のサブ見出し（FaqPage）',
  },
  'terms': {
    page_title: 'ヒーロー・パンくず・見出し（TermsOfServicePage）',
    page_subtitle: '英字のサブ見出し（TermsOfServicePage）',
    intro: '導入文（ページ冒頭の説明）',
    copyright_title: 'セクション見出し：著作権等について',
    copyright_body: '本文：著作権等について（HTML可）',
    link_title: 'セクション見出し：リンクについて',
    link_body: '本文：リンクについて（HTML可）',
    disclaimer_title: 'セクション見出し：免責事項',
    disclaimer_body: '本文：免責事項（HTML可）',
    security_title: 'セクション見出し：セキュリティについて',
    security_body: '本文：セキュリティについて（HTML可）',
    cookie_title: 'セクション見出し：クッキー(Cookie)について',
    cookie_body: '本文：クッキー(Cookie)について（HTML可）',
    environment_title: 'セクション見出し：ご利用環境について',
    environment_body: '本文：ご利用環境について（HTML可）',
    prohibited_title: 'セクション見出し：禁止される行為',
    prohibited_body: '本文：禁止される行為（HTML可）',
    article8_title: 'セクション見出し：第8条（利用規約の変更）',
    article8_body: '本文：第8条（利用規約の変更）（HTML可）',
  },
  'transaction-law': {
    page_title: 'ヒーロー・パンくず・見出し（TransactionLawPage）',
    page_subtitle: '英字のサブ見出し（TransactionLawPage）',
  },
  'sitemap': {
    page_title: 'ヒーロー・パンくず・見出し（SitemapPage）',
    page_subtitle: '英字のサブ見出し（SitemapPage）',
    cta_primary: '下部ボタン（お問い合わせ）',
    cta_secondary: '下部ボタン（入会）',
  },
  'consulting': {
    page_title: 'ヒーロー・パンくず（CRIConsultingPage）',
    page_subtitle: '英字のサブ見出し（CRIConsultingPage）',
    what_title: '見出し：CRI 経営コンサルティングとは？',
    what_subtitle: '英字：consulting',
    what_content_subtitle: '小見出し（英字）',
    what_content_heading: '小見出し（日本語）',
    what_content_body: '導入本文（HTML可）',
    duties_title: '見出し：主な業務',
    duties_subtitle: '英字：main duties',
    duties_intro: '主な業務の導入（HTML）',
    duties_label: '左側ラベル（MAIN DUTIES）',
    duties_heading: '主な業務の見出し',
    duties_list: '主な業務のリスト（HTML可）',
    support_title: '見出し：サポート内容と費用',
    support_subtitle_en: '英字：contents and costs',
    support_intro: '導入（HTML可）',
    support_free_title: '無料枠のタイトル',
    support_paid_title: '有料枠のタイトル',
    achievements_title: '見出し：実績紹介',
    achievements_subtitle: '英字：achievements',
    cta_primary: '最下部ボタン（お問い合わせ）',
    cta_secondary: '最下部ボタン（入会）',
  },
  'about-institute': {
    page_title: 'ヒーロー・パンくず（AboutInstitutePage）',
    page_subtitle: '英字のサブ見出し（AboutInstitutePage）',
    about_title: '導入セクション見出し',
    about_subtitle: '導入セクション英字',
    about_body: '導入セクション本文（HTML可）',
    service_title: 'サービス概要見出し',
    service_subtitle: 'サービス概要英字',
    service1_title: 'カード1 見出し',
    service1_desc: 'カード1 説明文',
    service1_list: 'カード1 詳細（HTML可）',
    service2_title: 'カード2 見出し',
    service2_desc: 'カード2 説明文',
    service3_title: 'カード3 見出し',
    service3_desc: 'カード3 説明文',
    cta_primary: '最下部ボタン（お問い合わせ）',
    cta_secondary: '最下部ボタン（入会）',
  },
  'about': {
    page_title: 'ヒーロー見出し（AboutPage）',
    page_subtitle: 'ヒーロー英字（AboutPage）',
    mission_title: '経営理念セクションの見出し',
    mission_body: '経営理念セクションの本文',
    message_title: 'ご挨拶セクション見出し',
    message_subtitle: 'ご挨拶セクション英字',
    message_signature: 'ご挨拶の署名',
  },
  'membership': {
    page_title: 'ヒーロー・パンくず（MembershipPage）',
    page_subtitle: '英字のサブ見出し（MembershipPage）',
    cta_primary: '下部ボタン（お問い合わせ）',
    cta_secondary: '下部ボタン（入会）',
  },
  'seminars-current': {
    page_title: 'ヒーロー・パンくず（CurrentSeminarsPage）',
    page_subtitle: '英字のサブ見出し（CurrentSeminarsPage）',
  }
}

export default {
  name: 'NewPageEditForm',
  components: {
    AdminLayout
  },
  data() {
    return {
      formData: {
        page_key: '',
        title: '',
        content: {},
        meta_description: '',
        meta_keywords: '',
        is_published: false,
        images: []
      },
      contentMode: 'wysiwyg',
      contentJson: '',
      contentHtml: '',
      showPreview: true,
      textsEditor: [],
      linksEditor: [],
      jsonError: '',
      loading: false,
      submitLoading: false,
      error: '',
      submitError: '',
      successMessage: '',
      showImageUploadModal: false,
      selectedImage: null,
      selectedImagePreview: '',
      newImage: {
        alt: '',
        description: '',
        url: ''
      },
      editingImageIndex: -1,
      // ライブプレビューのデバイス幅切替
      previewDevice: 'desktop'
    }
  },
  computed: {
    isNew() {
      return this.$route.params.pageKey === 'new'
    },
    pageKey() {
      return this.$route.params.pageKey
    },
    previewPath() {
      const key = this.formData.page_key || this.pageKey || ''
      const map = {
        'home': '/#/',
        'about': '/#/about',
        'company-profile': '/#/company-profile',
        'sitemap': '/#/sitemap',
        'contact': '/#/contact',
        'consulting': '/#/consulting',
        'membership': '/#/membership',
        'glossary': '/#/glossary',
        'economic-statistics': '/#/economic-statistics',
        'seminars-current': '/#/seminars/current',
        'publications': '/#/publications-public',
        'terms': '/#/terms',
        'privacy': '/#/privacy',
        'faq': '/#/faq',
        'transaction-law': '/#/transaction-law',
        'news': '/#/news',
        'financial-reports': '/#/financial-reports'
      }
      return map[key] || '/#/'
    },
    previewUrl() {
      const base = this.previewPath
      const sep = base.includes('?') ? '&' : '?'
      // cmsEdit=1 を付けるとプレビュー側が contenteditable になり、逆方向に編集が反映されます
      return `${base}${sep}cmsPreview=1&cmsEdit=1`
    },
    recommendedKeys() {
      const key = this.formData.page_key || this.pageKey || ''
      return RECOMMENDED_KEYS[key] || []
    },
    previewWidthPx() {
      switch (this.previewDevice) {
        case 'mobile': return 375
        case 'tablet': return 900
        case 'desktop':
        default: return 1200
      }
    }
  },
  watch: {
    contentJson(newValue) {
      this.jsonError = ''
      try {
        this.formData.content = JSON.parse(newValue)
      } catch (e) {
        this.jsonError = 'JSONの形式が正しくありません: ' + e.message
      }
      this.postToPreview()
    },
    contentMode(newMode, oldMode) {
      if ((newMode === 'html' || newMode === 'wysiwyg') && oldMode !== newMode) {
        this.contentHtml = this.extractHtmlFromContent()
      }
      if (newMode === 'json') {
        this.contentJson = JSON.stringify(this.formData.content || {}, null, 2)
      }
      if (newMode === 'fields') {
        this.ensureFieldsPreset()
      }
      if (newMode === 'live') {
        this.$nextTick(() => this.postToPreview())
      }
    }
  },
  async mounted() {
    const token = localStorage.getItem('admin_token')
    
    if (!token) {
      this.$router.push('/admin')
      return
    }

    if (!this.isNew) {
      await this.fetchPageData()
    } else {
      const initial = {
        title: '新しいページ',
        description: 'ページの説明をここに入力してください'
      }
      this.formData.content = initial
      this.contentJson = JSON.stringify(initial, null, 2)
      this.contentHtml = ''
    }
    this.$nextTick(() => this.postToPreview())
  },
  methods: {
    text(k) {
      const key = (k || '').trim()
      const row = this.textsEditor.find(r => (r.key||'').trim() === key)
      return row ? row.value : ''
    },
    focusOrAddKey(k) {
      const key = (k || '').trim()
      const idx = this.textsEditor.findIndex(r => (r.key||'').trim() === key)
      if (idx === -1) {
        this.textsEditor.push({ _id: `rk-${key}-${Date.now()}-${Math.random()}`, key, value: '' })
        this.$nextTick(() => {
          const inputs = this.$el.querySelectorAll('.field-row .field-key')
          if (inputs && inputs.length) inputs[inputs.length-1].focus()
        })
      } else {
        this.$nextTick(() => {
          const inputs = this.$el.querySelectorAll('.field-row .field-key')
          if (inputs && inputs[idx]) inputs[idx].focus()
        })
      }
    },
    ensureFieldsPreset() {
      // 既存content.textsやHTMLから値を推定しつつ推奨キーをプリセット
      const existing = {}
      try {
        const c = this.formData?.content
        if (c && typeof c === 'object' && c.texts && typeof c.texts === 'object') {
          Object.assign(existing, c.texts)
        }
      } catch (_) {}

      // HTMLからの簡易抽出（h1, p）
      try {
        const html = this.extractHtmlFromContent()
        if (html) {
          const h1 = (html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/i) || [null, ''])[1]
          const p = (html.match(/<p[^>]*>([\s\S]*?)<\/p>/i) || [null, ''])[1]
          if (h1 && !existing.page_title) existing.page_title = h1.replace(/<[^>]+>/g, '').trim()
          if (p && !existing.lead) existing.lead = p.replace(/<[^>]+>/g, '').trim()
        }
      } catch (_) {}

      const toAdd = (this.recommendedKeys || []).filter(k => !this.hasTextKey(k))
      for (const k of toAdd) {
        const v = existing[k] || ''
        this.textsEditor.push({ _id: `rk-${k}-${Date.now()}-${Math.random()}`, key: k, value: v })
      }
    },
    // Inline editor helpers
    execInline(cmd) {
      try { document.execCommand(cmd, false, null) } catch (_) {}
      this.captureInline()
    },
    formatInline(tag) {
      try { document.execCommand('formatBlock', false, tag) } catch (_) {}
      this.captureInline()
    },
    insertInlineLink() {
      const url = prompt('リンクURLを入力してください（https:// または / で始まる）', 'https://')
      if (!url) return
      try { document.execCommand('createLink', false, url) } catch (_) {}
      this.captureInline()
    },
    onInlineInput() { this.captureInline() },
    captureInline() {
      const el = this.$refs.inlineEditor
      if (el) this.contentHtml = el.innerHTML
    },
    postToPreview() {
      let html = this.contentHtml || ''
      if (!html) {
        try {
          const base = this.contentJson ? JSON.parse(this.contentJson) : {}
          if (typeof base.html === 'string') html = base.html
          if (!html && base.texts) {
            html = Object.keys(base.texts).map(k => `<p>${base.texts[k]}</p>`).join('')
          }
        } catch(_) {}
      }
      try { localStorage.setItem(`cms_preview_${this.pageKey}`, html || '') } catch(_) {}
      const frame = this.$refs.liveFrame
      if (frame && frame.contentWindow) {
        frame.contentWindow.postMessage({ type: 'cms-preview', pageKey: this.pageKey, html }, '*')
      }
    },
    refreshPreview() {
      const frame = this.$refs.liveFrame
      if (frame) frame.src = this.previewUrl
      setTimeout(() => this.postToPreview(), 300)
    },
    extractHtmlFromContent() {
      const c = this.formData?.content
      if (!c) return this.contentHtml || ''
      if (typeof c === 'string') return c
      if (typeof c.html === 'string') return c.html
      if (c.texts && typeof c.texts === 'object') {
        const title = c.texts.page_title || c.title || ''
        const lead = c.texts.lead || ''
        let html = ''
        if (title) html += `<h1>${title}</h1>`
        if (lead) html += `<p>${lead}</p>`
        return html
      }
      return this.contentHtml || ''
    },
    execCmd(cmd) {
      document.execCommand(cmd, false, null)
      this.onWysiwygInput()
    },
    formatBlock(block) {
      document.execCommand('formatBlock', false, block)
      this.onWysiwygInput()
    },
    insertLink() {
      const url = prompt('リンクURLを入力してください (https:// または / から開始)')
      if (!url) return
      document.execCommand('createLink', false, url)
      this.onWysiwygInput()
    },
    onWysiwygInput() {
      const el = this.$refs.wysiwyg
      if (el) {
        this.contentHtml = el.innerHTML
      }
    },
    async fetchPageData() {
      this.loading = true
      this.error = ''

      try {
        const data = await mockServer.getPage(this.pageKey)
        this.formData = {
          ...data,
          images: data.images || []
        }
        this.contentJson = JSON.stringify(data.content || data, null, 2)
        // HTML/WYSIWYG 初期値
        try {
          this.contentHtml = this.extractHtmlFromContent()
        } catch (e) {
          this.contentHtml = ''
        }
        // Initialize fields editor from content.texts if available
        const texts = (data && data.content && data.content.texts) ? data.content.texts : {}
        this.textsEditor = Object.keys(texts).map((k) => ({ _id: `${k}-${Date.now()}-${Math.random()}`, key: k, value: texts[k] }))
        const links = (data && data.content && data.content.links) ? data.content.links : {}
        this.linksEditor = Object.keys(links).map((k) => ({ _id: `l-${k}-${Date.now()}-${Math.random()}`, key: k, value: links[k] }))
        if (this.contentMode === 'fields') {
          this.ensureFieldsPreset()
        }
      } catch (err) {
        this.error = 'ページデータの取得に失敗しました'
        console.error(err)
      } finally {
        this.loading = false
      }
    },
    
    handleImageSelect(event) {
      const file = event.target.files[0]
      if (!file) return
      
      if (file.size > 5 * 1024 * 1024) {
        this.submitError = '画像サイズは5MB以下にしてください'
        return
      }
      
      this.selectedImage = file
      
      // プレビュー用のURLを作成
      const reader = new FileReader()
      reader.onload = (e) => {
        this.selectedImagePreview = e.target.result
      }
      reader.readAsDataURL(file)
    },
    
    addImage() {
      if (!this.selectedImage) return
      
      const reader = new FileReader()
      reader.onload = (e) => {
        const newImageData = {
          id: Date.now(),
          url: e.target.result,
          alt: this.newImage.alt || this.selectedImage.name,
          description: this.newImage.description || ''
        }
        
        if (this.editingImageIndex >= 0) {
          // 既存の画像を更新
          this.formData.images.splice(this.editingImageIndex, 1, newImageData)
          this.editingImageIndex = -1
        } else {
          // 新しい画像を追加
          if (!this.formData.images) {
            this.formData.images = []
          }
          this.formData.images.push(newImageData)
        }
        
        // モーダルをリセット
        this.resetImageModal()
        
        // 成功メッセージ
        this.successMessage = '画像が追加されました'
        setTimeout(() => {
          this.successMessage = ''
        }, 3000)
      }
      reader.readAsDataURL(this.selectedImage)
    },
    
    editImage(index) {
      const image = this.formData.images[index]
      this.editingImageIndex = index
      this.newImage = {
        alt: image.alt,
        description: image.description
      }
      this.selectedImagePreview = image.url
      this.selectedImage = true // 画像が既に選択されている状態
      this.showImageUploadModal = true
    },
    
    deleteImage(index) {
      if (!confirm('この画像を削除してもよろしいですか？')) {
        return
      }
      
      this.formData.images.splice(index, 1)
      this.successMessage = '画像が削除されました'
      setTimeout(() => {
        this.successMessage = ''
      }, 3000)
    },
    
    resetImageModal() {
      this.showImageUploadModal = false
      this.selectedImage = null
      this.selectedImagePreview = ''
      this.newImage = {
        alt: '',
        description: '',
        url: ''
      }
      this.editingImageIndex = -1
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },
    addTextField() {
      this.textsEditor.push({ _id: `new-${Date.now()}-${Math.random()}`, key: '', value: '' })
    },
    removeTextField(index) {
      this.textsEditor.splice(index, 1)
    },
    addLinkField() {
      this.linksEditor.push({ _id: `ln-${Date.now()}-${Math.random()}`, key: '', value: '' })
    },
    removeLinkField(index) {
      this.linksEditor.splice(index, 1)
    },
    hasTextKey(k) {
      const key = (k || '').trim()
      return this.textsEditor.some(r => (r.key || '').trim() === key)
    },
    addMissingRecommendedKeys() {
      const toAdd = (this.recommendedKeys || []).filter(k => !this.hasTextKey(k))
      for (const k of toAdd) {
        this.textsEditor.push({ _id: `rk-${k}-${Date.now()}-${Math.random()}`, key: k, value: '' })
      }
    },
    getKeyLimit(k) {
      const key = (k || '').trim()
      return TEXT_LIMITS[key] || null
    },
    getKeyLabel(k) {
      const key = (k || '').trim()
      return KEY_HELP[key]?.label || ''
    },
    getKeyDesc(k) {
      const key = (k || '').trim()
      return KEY_HELP[key]?.desc || ''
    },
    getKeyPlaceholder(k) {
      const key = (k || '').trim()
      return KEY_HELP[key]?.placeholder || ''
    },
    getKeyLocation(k) {
      const page = (this.formData.page_key || this.pageKey || '').trim()
      const key = (k || '').trim()
      return (KEY_LOCATIONS[page] && KEY_LOCATIONS[page][key]) ? KEY_LOCATIONS[page][key] : ''
    },
    reloadFieldsFromJson() {
      try {
        const base = this.contentJson ? JSON.parse(this.contentJson) : {}
        const texts = base?.texts || {}
        const links = base?.links || {}
        this.textsEditor = Object.keys(texts).map((k) => ({ _id: `${k}-${Date.now()}-${Math.random()}`, key: k, value: texts[k] }))
        this.linksEditor = Object.keys(links).map((k) => ({ _id: `l-${k}-${Date.now()}-${Math.random()}`, key: k, value: links[k] }))
      } catch(e) {
        this.submitError = 'JSONを読み込めませんでした: ' + e.message
      }
    },
    isValidLink(url) {
      if (!url) return true
      return /^\//.test(url) || /^https?:\/\//i.test(url)
    },
    addMissingLinkKeys() {
      const defaults = ['cta_primary', 'cta_secondary']
      const exist = new Set(this.linksEditor.map(r => (r.key||'').trim()))
      defaults.forEach(k => { if (!exist.has(k)) this.linksEditor.push({ _id: `ln-${k}-${Date.now()}-${Math.random()}`, key: k, value: '' }) })
    },
    collectTextWarnings() {
      const warnings = []
      for (const row of this.textsEditor) {
        const key = (row.key || '').trim()
        const limit = this.getKeyLimit(key)
        const len = (row.value || '').length
        if (limit && len > limit) {
          warnings.push(`${key}: ${len}/${limit}`)
        }
      }
      return warnings
    },
    async handleSubmit() {
      this.submitLoading = true
      this.submitError = ''
      this.successMessage = ''

      try {
        // Fieldsモードの長文ガード（ソフト）
        if (this.contentMode === 'fields') {
          const warns = this.collectTextWarnings()
          if (warns.length) {
            const proceed = confirm(`一部のフィールドが推奨文字数を超えています:\n\n${warns.join('\n')}\n\nこのまま保存しますか？`)
            if (!proceed) {
              this.submitLoading = false
              return
            }
          }
        }
        // コンテンツのモードに応じて content を設定
        if (this.contentMode === 'html' || this.contentMode === 'wysiwyg' || this.contentMode === 'inline') {
          this.formData.content = this.contentHtml || ''
        } else if (this.contentMode === 'fields') {
          // Merge with existing JSON if valid, else new object
          let base = {}
          try { base = this.contentJson ? JSON.parse(this.contentJson) : {} } catch(e) { base = {} }
          const texts = {}
          for (const row of this.textsEditor) {
            const k = (row.key || '').trim()
            if (!k) continue
            texts[k] = row.value || ''
          }
          const links = {}
          for (const row of this.linksEditor) {
            const k = (row.key || '').trim()
            if (!k) continue
            if (row.value && !this.isValidLink(row.value)) {
              // 軽いガード：許可形式以外は無視
              continue
            }
            links[k] = row.value || ''
          }
          this.formData.content = { ...(base || {}), texts, links }
        } else {
          try {
            this.formData.content = JSON.parse(this.contentJson)
          } catch (e) {
            this.submitError = 'JSONの形式が正しくありません: ' + e.message
            this.submitLoading = false
            return
          }
        }
        
        // 送信データの準備
        const submitData = {
          ...this.formData,
          // 画像データも含める
          images: this.formData.images || []
        }
        
        if (this.isNew) {
          // 新規作成機能
          if (!submitData.page_key) {
            this.submitError = 'ページキーは必須です'
            this.submitLoading = false
            return
          }
          
          try {
            const res = await apiClient.request('POST', '/api/admin/pages', submitData)
            if (!(res && (res.success || res.id || res.page || res.data))) {
              throw new Error(res?.message || '作成に失敗しました')
            }
            this.successMessage = 'ページを作成しました'
            setTimeout(() => {
              this.$router.push('/admin/pages')
            }, 1500)
          } catch (e) {
            this.submitError = '新規ページ作成に失敗しました: ' + e.message
          }
        } else {
          // 既存ページの更新
          const key = this.formData.page_key || this.pageKey
          const res = await apiClient.request('PUT', `/api/admin/pages/${key}`, submitData)
          if (!(res && (res.success || res.id || res.page || res.data))) {
            throw new Error(res?.message || '更新に失敗しました')
          }
          this.successMessage = 'ページを更新しました'
          
          // 画像が含まれる場合、成功メッセージを拡張
          if (submitData.images && submitData.images.length > 0) {
            this.successMessage += `（${submitData.images.length}枚の画像を含む）`
          }
          
          // 更新後に最新データを再取得
          setTimeout(() => {
            this.fetchPageData()
          }, 1000)
        }
      } catch (err) {
        if (err.response?.data?.errors) {
          this.submitError = Object.values(err.response.data.errors).flat().join(', ')
        } else {
          this.submitError = this.isNew ? 'ページの作成に失敗しました' : 'ページの更新に失敗しました'
        }
        console.error(err)
      } finally {
        this.submitLoading = false
      }
    },
    goBack() {
      this.$router.push('/admin/pages')
    },
    handleLogout() {
      localStorage.removeItem('admin_token')
      localStorage.removeItem('adminUser')
      delete axios.defaults.headers.common['Authorization']
      this.$router.push('/admin')
    }
  }
}
</script>

<style scoped>
.dashboard {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  min-height: calc(100vh - 120px);
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid #e5e5e5;
  background-color: #f8f9fa;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.back-btn {
  background: none;
  border: none;
  color: #0066cc;
  font-size: 14px;
  cursor: pointer;
  padding: 8px 0;
  transition: color 0.2s;
}

.back-btn:hover {
  color: #0052a3;
  text-decoration: underline;
}

.page-title {
  font-size: 24px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.logout-btn {
  background-color: #1A1A1A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.logout-btn:hover {
  background-color: #555;
}

.form-container {
  padding: 24px;
  max-width: 800px;
  margin: 0 auto;
}

.loading {
  text-align: center;
  padding: 60px 20px;
  color: #666;
  font-size: 16px;
}

.error-container {
  padding: 20px;
  text-align: center;
}

.error-message {
  background-color: #fee2e2;
  border: 1px solid #fca5a5;
  color: #dc2626;
  padding: 16px;
  border-radius: 8px;
  font-size: 14px;
}

.form-section {
  margin-bottom: 32px;
}

.section-title {
  font-size: 18px;
  font-weight: 600;
  color: #1A1A1A;
  margin: 0 0 16px 0;
  padding-bottom: 8px;
  border-bottom: 2px solid #da5761;
}

.form-group {
  margin-bottom: 24px;
}

.form-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #1A1A1A;
  margin-bottom: 8px;
}

.required {
  color: #dc2626;
  font-weight: 500;
}

.form-input {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
  box-sizing: border-box;
  font-family: inherit;
}

.form-input:focus {
  outline: none;
  border-color: #da5761;
}

.form-input.disabled {
  background-color: #f5f5f5;
  color: #666;
  cursor: not-allowed;
}

.form-help {
  font-size: 12px;
  color: #666;
  margin-top: 4px;
  margin-bottom: 0;
}

.json-editor-container {
  position: relative;
}

.json-editor {
  width: 100%;
  padding: 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  font-size: 13px;
  font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
  line-height: 1.5;
  resize: vertical;
  min-height: 300px;
  box-sizing: border-box;
  transition: border-color 0.2s;
}

/* HTML/WYSIWYG editor styles */
.html-editor {
  width: 100%;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  padding: 12px;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
  font-size: 13px;
}
.html-preview {
  margin-top: 12px;
  border: 1px solid #eee;
  border-radius: 6px;
  padding: 16px;
  background: #fafafa;
}
.editor-toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
  border: 1px solid #d0d0d0;
  border-bottom: none;
  border-radius: 6px 6px 0 0;
  padding: 8px;
  background: #f7f7f7;
}
.tb-btn {
  border: 1px solid #ccc;
  background: white;
  border-radius: 4px;
  padding: 4px 8px;
  font-size: 13px;
  cursor: pointer;
}
.tb-btn:hover { background: #f0f0f0; }
.sep { width: 1px; height: 18px; background: #ddd; display: inline-block; margin: 0 4px; }
.flex-spacer { flex: 1; }
.preview-toggle, .preview-inline { font-size: 13px; color: #555; }
.editor-split {
  display: flex;
  border: 1px solid #d0d0d0;
  border-radius: 0 0 6px 6px;
  min-height: 240px;
}
.editor-split.with-preview .wysiwyg-editor { width: 50%; }
.editor-split.with-preview .wysiwyg-preview { width: 50%; display: block; }
.wysiwyg-editor {
  width: 100%;
  padding: 12px;
  min-height: 240px;
  outline: none;
  background: white;
}
.wysiwyg-preview {
  display: none;
  border-left: 1px solid #eee;
  background: #fafafa;
}
.preview-inner { padding: 12px; }

/* Live preview (iframe) */
.preview-toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 8px 0 12px 0;
  font-size: 13px;
  color: #555;
}
.device-toggle { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.device-select { padding: 6px 8px; border: 1px solid #d0d0d0; border-radius: 4px; font-size: 13px; }
.live-preview-wrap {
  overflow-x: auto;
  padding-bottom: 8px;
}
.live-preview-frame {
  margin: 0 auto;
}
.live-preview {
  width: 100%;
  min-height: 700px;
  border: 1px solid #e5e5e5;
  border-radius: 6px;
  background: #fff;
}

/* Inline page-like editor */
.inline-toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
  border: 1px solid #d0d0d0;
  border-bottom: none;
  border-radius: 6px 6px 0 0;
  padding: 8px;
  background: #f7f7f7;
  margin-top: 10px;
}
.inline-surface {
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  background: #f3f4f6;
  padding: 12px;
}
.inline-page {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.inline-hero {
  background: #ececec;
  padding: 24px;
  text-align: center;
  color: #666;
  font-weight: 600;
}
.inline-body {
  padding: 24px;
  min-height: 260px;
}
.inline-editor {
  min-height: 220px;
  outline: none;
}
.inline-footer {
  background: #f7f7f7;
  padding: 16px;
  text-align: center;
  color: #777;
}

/* Fields mode styles */
.fields-editor {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.field-head {
  display: grid;
  grid-template-columns: 1.2fr 2fr auto auto;
  gap: 8px;
  font-size: 12px;
  color: #666;
  padding: 4px 2px;
}

.field-row {
  display: grid;
  grid-template-columns: 1.2fr 2fr auto auto;
  gap: 8px;
  align-items: center;
}

.field-row-warning .field-value {
  border-color: #f59e0b; /* amber-500 */
}

.field-key { }
.field-value { }

.field-hint {
  font-size: 12px;
  color: #666;
}

.counter {
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  padding: 2px 6px;
  border-radius: 4px;
}

.key-help {
  margin-top: 4px;
  color: #6b7280;
}

.fields-guide {
  background: #f8fafc;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  padding: 12px;
  margin-bottom: 10px;
}

.fields-guide .guide-title {
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 6px;
}

.fields-guide ol {
  margin: 0 0 8px 18px;
  padding: 0;
  font-size: 12px;
  color: #4b5563;
}

.fields-guide .guide-actions {
  display: flex;
  gap: 8px;
}

.recommended-keys {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 10px;
}

.recommended-keys .subtitle {
  font-size: 13px;
  color: #666;
}

.recommended-keys .chips {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.chip {
  font-size: 12px;
  padding: 4px 8px;
  border-radius: 12px;
  border: 1px solid #e5e5e5;
}

.chip-ok {
  background: #e8f5e9; /* green-50 */
  border-color: #a7f3d0; /* green-200 */
}

.chip-missing {
  background: #fff7ed; /* orange-50 */
  border-color: #fdba74; /* orange-300 */
}

.json-editor:focus {
  outline: none;
  border-color: #da5761;
}

.json-editor.error {
  border-color: #dc2626;
}

.json-error {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
  padding: 8px 12px;
  background-color: #fee2e2;
  border: 1px solid #fca5a5;
  color: #dc2626;
  border-radius: 4px;
  font-size: 12px;
}

.json-success {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
  padding: 8px 12px;
  background-color: #d1fae5;
  border: 1px solid #6ee7b7;
  color: #065f46;
  border-radius: 4px;
  font-size: 12px;
}

/* Live preview for Fields mode */
.fields-preview {
  margin: 20px 0;
  border: 1px dashed #d9d9d9;
  border-radius: 8px;
  background: #fafafa;
}
.preview-hero {
  background: linear-gradient(180deg,#f5f5f5,#fff);
  padding: 16px;
  border-radius: 8px;
}
.pv-title { font-size: 20px; margin: 0 0 4px 0; color:#1A1A1A; }
.pv-subtitle { font-size: 12px; color:#9c9c9c; margin-bottom: 8px; }
.pv-lead { font-size: 13px; color:#555; margin: 0 0 12px 0; }
.pv-cta button { font-size: 12px; }

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  padding: 16px;
  border: 2px solid #e5e5e5;
  border-radius: 6px;
  transition: border-color 0.2s;
}

.checkbox-label:hover {
  border-color: #da5761;
}

.checkbox-input {
  display: none;
}

.checkbox-custom {
  width: 20px;
  height: 20px;
  border: 2px solid #d1d5db;
  border-radius: 4px;
  position: relative;
  transition: all 0.2s;
}

.checkbox-input:checked + .checkbox-custom {
  background-color: #da5761;
  border-color: #da5761;
}

.checkbox-input:checked + .checkbox-custom::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 6px;
  width: 4px;
  height: 8px;
  border: 2px solid white;
  border-left: none;
  border-top: none;
  transform: rotate(45deg);
}

.checkbox-text {
  font-size: 14px;
  font-weight: 500;
  color: #1A1A1A;
}

.message {
  padding: 16px;
  border-radius: 6px;
  margin-bottom: 24px;
  font-size: 14px;
}

.success-message {
  background-color: #d1fae5;
  border: 1px solid #6ee7b7;
  color: #065f46;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 24px;
  border-top: 1px solid #e5e5e5;
}

.btn {
  padding: 12px 24px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  min-width: 120px;
}

.btn-secondary {
  background-color: #f5f5f5;
  color: #1A1A1A;
  border: 1px solid #d1d5db;
}

.btn-secondary:hover {
  background-color: #e5e5e5;
}

.btn-primary {
  background-color: #da5761;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background-color: #c44853;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* 画像管理スタイル */
.image-management {
  margin-top: 16px;
}

.image-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.image-item {
  border: 1px solid #e5e5e5;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  background-color: white;
}

.image-preview {
  height: 160px;
  overflow: hidden;
  background-color: #f5f5f5;
}

.preview-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-details {
  padding: 12px;
}

.image-info {
  margin-bottom: 12px;
}

.image-name {
  font-weight: 500;
  font-size: 14px;
  color: #1A1A1A;
  margin-bottom: 4px;
}

.image-path {
  font-size: 12px;
  color: #666;
  word-break: break-all;
}

.image-actions {
  display: flex;
  gap: 8px;
}

.image-btn {
  flex: 1;
  padding: 8px;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
}

.edit-image-btn {
  background-color: #f5f5f5;
  color: #1A1A1A;
  border: 1px solid #d1d5db;
}

.edit-image-btn:hover {
  background-color: #e5e5e5;
}

.delete-image-btn {
  background-color: #fee2e2;
  color: #dc2626;
  border: 1px solid #fca5a5;
}

.delete-image-btn:hover {
  background-color: #fecaca;
}

.no-images {
  padding: 32px;
  text-align: center;
  background-color: #f9fafb;
  border: 1px dashed #d1d5db;
  border-radius: 8px;
  color: #666;
  margin-bottom: 24px;
}

.add-image-section {
  margin-bottom: 24px;
}

.add-image-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 16px;
  background-color: #f9fafb;
  border: 1px dashed #d1d5db;
  border-radius: 8px;
  color: #1A1A1A;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  width: 100%;
  justify-content: center;
}

.add-image-btn:hover {
  background-color: #f3f4f6;
  border-color: #da5761;
  color: #da5761;
}

.add-image-btn svg {
  transition: all 0.2s;
}

.add-image-btn:hover svg {
  color: #da5761;
}

/* モーダル */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-container {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  width: 100%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  border-bottom: 1px solid #e5e5e5;
}

.modal-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #1A1A1A;
}

.close-modal {
  background: none;
  border: none;
  font-size: 24px;
  color: #666;
  cursor: pointer;
  padding: 0;
  line-height: 1;
}

.modal-body {
  padding: 24px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 16px 24px;
  border-top: 1px solid #e5e5e5;
}

.file-input {
  padding: 12px;
  border: 1px solid #e5e5e5;
  border-radius: 6px;
  width: 100%;
  background-color: #f9fafb;
}

.image-preview-container {
  margin: 16px 0;
  text-align: center;
}

.image-preview-large {
  max-width: 100%;
  max-height: 300px;
  border: 1px solid #e5e5e5;
  border-radius: 4px;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    gap: 16px;
    align-items: stretch;
  }
  
  .header-left {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .form-container {
    padding: 16px;
  }
  
  .page-title {
    font-size: 20px;
  }
  
  .form-actions {
    flex-direction: column-reverse;
  }
  
  .btn {
    width: 100%;
  }
  
  .json-editor {
    font-size: 12px;
    min-height: 250px;
  }
}

@media (max-width: 480px) {
  .page-header {
    padding: 16px;
  }
  
  .form-container {
    padding: 12px;
  }
  
  .page-title {
    font-size: 18px;
  }
  
  .form-section {
    margin-bottom: 24px;
  }
  
  .json-editor {
    min-height: 200px;
  }
}
</style>
