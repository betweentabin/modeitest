-- 刊行物データを挿入（修正版）
INSERT INTO publications (
    title, description, publication_date, category_id,
    author, pages, file_url, cover_image, file_size, 
    download_count, is_published, membership_level, published_at
) VALUES
('事業継承から描く九州の未来', 
 '最新の地域経済動向レポート。九州地域の製造業の動向と今後の展望について特集。', 
 '2025-01-28', (SELECT id FROM publication_categories WHERE slug = 'research'),
 'ちくぎん地域経済研究所', 45, '/files/kyushu-future.pdf', '/img/image-1.png', 2.1, 
 234, true, 'premium', '2025-01-28 10:00:00'),

('経営参考BOOK vol.52', 
 '事業承継をテーマに、成功事例と具体的な進め方を解説。', 
 '2025-01-25', (SELECT id FROM publication_categories WHERE slug = 'quarterly'),
 'ちくぎん地域経済研究所', 32, '/files/management-book-52.pdf', '/img/image-1.png', 1.8, 
 156, true, 'standard', '2025-01-25 10:00:00'),

('Hot Information Vol.323', 
 '2025年度の経済展望と地域企業が取り組むべき課題について特集。', 
 '2025-01-20', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 28, '/files/hot-info-323.pdf', '/img/image-1.png', 1.5, 
 89, true, 'basic', '2025-01-20 10:00:00'),

('Hot Information Vol.324', 
 'DX推進のポイントや、新たな成長戦略について詳しく解説。', 
 '2025-01-15', (SELECT id FROM publication_categories WHERE slug = 'special'),
 'ちくぎん地域経済研究所', 35, '/files/hot-info-324.pdf', '/img/image-1.png', 2.0, 
 45, true, 'free', '2025-01-15 10:00:00');

-- テスト用会員データ（修正版）
INSERT INTO members (
    email, password, company_name, representative_name, 
    phone, membership_type, status, joined_date, expiry_date, email_verified_at
) VALUES
('test1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 '株式会社テスト商事', '山田太郎', '090-1234-5678', 
 'premium', 'active', '2024-01-15', '2025-01-15', '2024-01-15 10:00:00'),

('test2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 '有限会社サンプル', '鈴木花子', '090-2345-6789', 
 'standard', 'active', '2024-03-20', '2025-03-20', '2024-03-20 14:00:00'),

('test3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'ABC工業株式会社', '佐藤次郎', '090-3456-7890', 
 'basic', 'active', '2024-06-10', '2025-06-10', '2024-06-10 09:00:00');
