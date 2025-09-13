<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

/**
 * Populate/normalize per-page non-KV images in PageContent->content['images'].
 *
 * This ensures Admin > メディア管理 で各ページ（media以外）に
 * 適切な初期URLが表示され、画像置換フローに載せられます。
 */
class PageNonKvImagesSeeder extends Seeder
{
    public function run(): void
    {
        // ABOUT: hero + mission section image (component reads content.images['hero'|'content'])
        $this->mergeImages('about', [
            'hero' => '/img/hero-image.png',
            'hero_mobile' => '/img/hero-image.png',
            'hero_tablet' => '/img/hero-image.png',
            // Used in AboutPage.vue: getImageUrl('content')
            'content' => '/img/image-1.png',
            // Optionally keep a message image slot for future wiring
            'message' => '/img/image-2.png',
        ]);

        // CRI Consulting: component has static <img>; register here for admin replacement first
        $this->mergeImages('cri-consulting', [
            'what_image' => 'https://api.builder.io/api/v1/image/assets/TEMP/f016525f0cc061901e592a57545785e894630484?width=940',
            'duties_image' => 'https://api.builder.io/api/v1/image/assets/TEMP/25a28ba9ea089f902a21c4d02c416034111f837a?width=1304',
        ]);

        // HOME: top banners (currently set via local data; reserved here for CMS migration)
        $this->mergeImages('home', [
            'banner_seminar' => '/img/---2.png',
            'banner_publications' => '/img/--.png',
            'banner_info' => '/img/---1.png',
            'banner_membership' => '/img/---7.png',
        ]);
    }

    private function mergeImages(string $pageKey, array $images): void
    {
        $page = PageContent::where('page_key', $pageKey)->first();
        if (!$page) {
            // Create a minimal page so media admin can manage immediately
            $page = PageContent::create([
                'page_key' => $pageKey,
                'title' => ucfirst(str_replace('-', ' ', $pageKey)),
                'content' => [ 'images' => $images ],
                'is_published' => true,
                'published_at' => now(),
            ]);
            return;
        }

        $content = $page->content ?? [];
        if (!is_array($content)) { $content = [ 'html' => (string)$content ]; }
        $existing = isset($content['images']) && is_array($content['images']) ? $content['images'] : [];
        // Our seeder values should override placeholders (e.g. '/img/hero-image.png') if present
        $content['images'] = array_replace($existing, $images);
        $page->update(['content' => $content]);
    }
}
