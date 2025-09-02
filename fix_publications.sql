-- 刊行物データを挿入（修正版2）
INSERT INTO publications (
    title, description, category, type, publication_date,
    author, pages, file_url, cover_image, price,
    is_published, is_downloadable, members_only, download_count, view_count
) VALUES
('事業継承から描く九州の未来', 
 '最新の地域経済動向レポート。九州地域の製造業の動向と今後の展望について特集。', 
 'research', 'report', '2025-01-28',
 'ちくぎん地域経済研究所', 45, '/files/kyushu-future.pdf', '/img/image-1.png', 3000.00,
 true, true, true, 234, 500),

('経営参考BOOK vol.52', 
 '事業承継をテーマに、成功事例と具体的な進め方を解説。', 
 'quarterly', 'book', '2025-01-25',
 'ちくぎん地域経済研究所', 32, '/files/management-book-52.pdf', '/img/image-1.png', 2000.00,
 true, true, true, 156, 300),

('Hot Information Vol.323', 
 '2025年度の経済展望と地域企業が取り組むべき課題について特集。', 
 'special', 'magazine', '2025-01-20',
 'ちくぎん地域経済研究所', 28, '/files/hot-info-323.pdf', '/img/image-1.png', 1500.00,
 true, true, false, 89, 200),

('Hot Information Vol.324', 
 'DX推進のポイントや、新たな成長戦略について詳しく解説。', 
 'special', 'magazine', '2025-01-15',
 'ちくぎん地域経済研究所', 35, '/files/hot-info-324.pdf', '/img/image-1.png', 1500.00,
 true, true, false, 45, 150);
