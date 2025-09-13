<template>
  <!-- Use HeroSlider if slides are provided -->
  <HeroSlider 
    v-if="slides && slides.length > 0"
    :slides="slides"
    :autoPlay="autoPlay"
    :autoPlayInterval="autoPlayInterval"
  />
  <!-- Fallback to single hero image -->
  <div v-else class="hero-section" :style="heroStyle">
    <div class="hero-overlay">
      <div class="hero-content">
        <!-- When cmsPageKey provided, render inline-editable texts -->
        <template v-if="cmsPageKey">
          <div class="hero-subtitle">
            <CmsText :pageKey="cmsPageKey" :fieldKey="subtitleFieldKey" tag="span" :fallback="subtitle || ''" />
          </div>
          <div class="hero-title">
            <CmsText :pageKey="cmsPageKey" :fieldKey="titleFieldKey" tag="span" :fallback="title || ''" />
          </div>
        </template>
        <template v-else>
          <div class="hero-subtitle">{{ subtitle }}</div>
          <div class="hero-title">{{ title }}</div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import CmsText from '@/components/CmsText.vue'
import HeroSlider from '@/components/HeroSlider.vue'
import { usePageText } from '@/composables/usePageText'

export default {
  name: "HeroSection",
  props: {
    title: {
      type: String,
      required: false,
      default: ''
    },
    subtitle: {
      type: String,
      default: ''
    },
    // Enable inline CMS on hero by providing page key + field keys
    cmsPageKey: {
      type: String,
      required: false,
      default: ''
    },
    titleFieldKey: {
      type: String,
      required: false,
      default: 'page_title'
    },
    subtitleFieldKey: {
      type: String,
      required: false,
      default: 'page_subtitle'
    },
    heroImage: {
      type: String,
      required: false,
      default: ''
    },
    mediaKey: {
      type: String,
      required: false,
      default: ''
    },
    // Slider functionality
    slides: {
      type: Array,
      required: false,
      default: () => []
    },
    autoPlay: {
      type: Boolean,
      default: true
    },
    autoPlayInterval: {
      type: Number,
      default: 5000
    }
  },
  components: { CmsText, HeroSlider },
  async mounted() {
    // lazy load media registry if mediaKey is provided
    if (this.mediaKey) {
      try {
        const mod = await import('@/composables/useMedia')
        const { useMedia } = mod
        this._media = useMedia()
        this._media.ensure()
      } catch (e) { /* noop */ }
    }
    // load page content for per-page KV hero (managed on each page)
    if (this.cmsPageKey) {
      try {
        this._pageText = usePageText(this.cmsPageKey)
        // Prefer admin when editing; otherwise public is fine. Force load to get fresh hero.
        await this._pageText.load({ force: true })
      } catch (e) { /* noop */ }
    }
  },
  computed: {
    resolvedImage() {
      // 1) per-page KV: prefer page content images (hero[_mobile|_tablet])
      const fromPage = this.pageHero()
      if (fromPage) return fromPage

      // 2) legacy media registry fallback
      const key = this.mediaKey
      if (key && this._media) {
        if (this._media.getResponsiveImage) {
          const v = this._media.getResponsiveImage(key, this.heroImage)
          return v || this.heroImage
        }
        if (this._media.getImage) {
          const v = this._media.getImage(key, this.heroImage)
          return v || this.heroImage
        }
      }
      // 3) static fallback
      return this.heroImage
    },
    heroStyle() {
      return {
        backgroundImage: `url('${this.resolvedImage || ''}')`
      };
    }
  }
  ,
  methods: {
    viewport() {
      try {
        const w = typeof window !== 'undefined' ? window.innerWidth : 1200
        if (w <= 600) return 'mobile'
        if (w <= 1024) return 'tablet'
        return 'desktop'
      } catch (_) { return 'desktop' }
    },
    getFromImagesMap(images, key) {
      const val = images?.[key]
      if (!val) return ''
      if (typeof val === 'string') return val
      if (typeof val === 'object' && val.url) return val.url
      return ''
    },
    pageHero() {
      try {
        const page = this._pageText?.page?.value
        const images = page?.content?.images || {}
        const vp = this.viewport()
        const candidates = vp === 'mobile'
          ? ['hero_mobile', 'hero_sm', 'hero']
          : vp === 'tablet'
          ? ['hero_tablet', 'hero_md', 'hero']
          : ['hero']
        for (const k of candidates) {
          const v = this.getFromImagesMap(images, k)
          if (typeof v === 'string' && v.length) return v
        }
        return ''
      } catch (_) { return '' }
    }
  }
};
</script>

<style scoped>
/* Hero Section */
.hero-section {
  width: 100%;
  height: 400px;
  background: lightgray center / cover no-repeat;
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
  position: relative;
}

.hero-overlay {
  background: rgba(77, 77, 77, 0.70);
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: flex-start;
  padding: 50px 30px;
  box-sizing: border-box;
}

.hero-content {
  color: white;
}

.hero-subtitle {
  color: white;
  font-size: clamp(18px, 4vw, 24px);
  font-weight: 700;
  text-align: left;
  line-height: 2.5;
  letter-spacing: -0.48px;
}

.hero-title {
  color: white;
  font-size: clamp(28px, 6vw, 40px);
  font-weight: 700;
  text-align: left;
  line-height: 1.5;
  letter-spacing: -0.8px;
}

/* レスポンシブ対応 */
@media (max-width: 1150px) {
  .hero-section {
    height: 350px;
  }
  
  .hero-overlay {
    padding: 40px 25px;
  }
  
  .hero-subtitle {
    font-size: clamp(16px, 3.5vw, 22px);
  }
  
  .hero-title {
    font-size: clamp(24px, 5.5vw, 36px);
  }
}

@media (max-width: 800px) {
  .hero-section {
    min-height: 250px;
    height: 280px;
    background-position: center 30%;
  }
  
  .hero-overlay {
    padding: 25px 20px;
  }
  
  .hero-subtitle {
    font-size: clamp(15px, 3vw, 20px);
    line-height: 2.2;
  }
  
  .hero-title {
    font-size: clamp(22px, 5vw, 32px);
    line-height: 1.4;
  }
}

@media (max-width: 600px) {
  .hero-section {
    min-height: 220px;
    height: 240px;
    background-position: center 25%;
  }
  
  .hero-overlay {
    padding: 20px 15px;
  }
  
  .hero-subtitle {
    font-size: clamp(14px, 2.8vw, 18px);
    line-height: 2.0;
  }
  
  .hero-title {
    font-size: clamp(20px, 4.5vw, 28px);
    line-height: 1.3;
  }
}

@media (max-width: 480px) {
  .hero-section {
    min-height: 200px;
    height: 220px;
    background-position: center 20%;
  }
  
  .hero-overlay {
    padding: 15px 12px;
  }
  
  .hero-subtitle {
    font-size: clamp(13px, 2.5vw, 16px);
    line-height: 1.8;
  }
  
  .hero-title {
    font-size: clamp(18px, 4vw, 24px);
    line-height: 1.2;
  }
}
</style>
