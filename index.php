<?php
// =====================================================
//  Website Katalog Produk – Versi PHP (Single File)
//  Fitur: Pencarian + Filter Kategori + Tipe/Varian per Produk,
//         Harga dinamis, Link WhatsApp dinamis, UI modern
// =====================================================

// 1) KONFIGURASI TOKO
$whatsapp = getenv('WHATSAPP') ?: '6281234567890'; // baca dari ENV WHATSAPP, fallback ke ini // ← ganti nomor kamu (format internasional tanpa +)
$storeName = 'Maherpedia Store';
$tagline   = 'Kualitas terbaik, harga bersahabat';

// 2) DATA PRODUK (contoh). Bebas ubah/ tambah.
$products = [
  [
    'id' => 1,
    'name' => 'ChatGPT',
    'price' => 45000,
    'category' => 'Tools',
    'rating' => 4.8,
    'tag' => 'Best Seller',
    'img' => 'https://images.unsplash.com/photo-1684487747720-1ba29cda82f8?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'types' => [
      ['name' => 'Sharing', 'price' => 45000],
      ['name' => 'Private', 'price' => 109000],
    ],
  ],
  [
    'id' => 2,
    'name' => 'Netflix',
    'price' => 35000,
    'category' => 'Streaming',
    'rating' => 4.6,
    'tag' => 'Favorit',
    'img' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'types' => [
      ['name' => 'Sharing',  'price' => 35000],
      ['name' => 'Private', 'price' => 105000],
    ],
  ],
  [
    'id' => 3,
    'name' => 'Disney+',
    'price' => 25000,
    'category' => 'Streaming',
    'rating' => 4.7,
    'tag' => 'Favorit',
    'img' => 'https://images.unsplash.com/photo-1662338571362-5ad7a300074a?q=80&w=1228&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'types' => [
      ['name' => 'Sharing', 'price' => 25000],
    ],
  ],
  [
    'id' => 4,
    'name' => 'Canva',
    'price' => 11000,
    'category' => 'Tools',
    'rating' => 4.5,
    'tag' => 'Hemat',
    'img' => 'https://images.unsplash.com/photo-1649091245823-18be815da4f7?q=80&w=1162&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'types' => [
      ['name' => 'Pro Invite', 'price' => 11000],
      ['name' => 'Lifetime',    'price' => 30000],
	  ['name' => 'Head',    'price' => 14000],
    ],
  ],
  [
    'id' => 5,
    'name' => 'Vidio',
    'price' => 40000,
    'category' => 'Streaming',
    'rating' => 4.9,
    'tag' => 'Premium',
    'img' => 'https://yt3.googleusercontent.com/ytc/AIdro_mpHh_f7FDgfWUnJdc6lhUYowj8PvMaKbCApiEuUDsV4ZE=s900-c-k-c0x00ffffff-no-rj',
    'types' => [
      ['name' => 'Platinum', 'price' => 40000],
    ],
  ],
  [
    'id' => 6,
    'name' => 'Capcut',
    'price' => 18000,
    'category' => 'Tools',
    'rating' => 4.6,
    'tag' => 'Limited',
    'img' => 'https://imgsrv2.voi.id/UIa1aQTzEhX8pgQ8XZtHk9ITKZdqCjYTQm4N9rJP3yU/auto/1200/675/sm/1/bG9jYWw6Ly8vcHVibGlzaGVycy8yMjcyMDQvMjAyMjExMTQxMDM0LW1haW4ucG5n.jpg',
    'types' => [
      ['name' => '30 Days', 'price' => 18000],
    ],
  ],
  [
    'id' => 7,
    'name' => 'Youtube Premium',
    'price' => 15000,
    'category' => 'Streaming',
    'rating' => 4.8,
    'tag' => 'Favorit',
    'img' => 'https://images.unsplash.com/photo-1611162616475-46b635cb6868?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'types' => [
      ['name' => 'Individual', 'price' => 15000],
	  ['name' => 'Family Head', 'price' => 30000],
    ],
  ],
  [
    'id' => 8,
    'name' => 'IQiyi',
    'price' => 14000,
    'category' => 'Streaming',
    'rating' => 4.7,
    'tag' => 'Limited',
    'img' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/97/MTA-159611146/iqiyi_iqiyi_vip_premium_1_tahun_full01_nwcb27ib.jpg',
    'types' => [
      ['name' => '1 Bulan Premium', 'price' => 14000],
	  ['name' => '3 Bulan Premium', 'price' => 16500],
	  ['name' => '12 Bulan Premium', 'price' => 19000],
    ],
  ],
  [
    'id' => 9,
    'name' => 'BStation',
    'price' => 15000,
    'category' => 'Streaming',
    'rating' => 4.8,
    'tag' => 'Limited',
    'img' => 'https://assets.telkomsel.com/public/2025-05/Bukan-Cuma-Nonton-Anime-Bstation-Bilibili-juga-Bisa-Diskusi-Bareng-Penonton-Lainnya.jpg?VersionId=6dUD2Ar0OYJ6MuWGfW.aW4FU4EPNzzA',
    'types' => [
      ['name' => 'Sharing', 'price' => 15000],
    ],
  ],
  [
    'id' => 10,
    'name' => 'Prime Video',
    'price' => 20000,
    'category' => 'Streaming',
    'rating' => 4.8,
    'tag' => 'Limited',
    'img' => 'https://m.media-amazon.com/images/G/01/support_images/GUID-A5E374A8-16DA-4B39-8E3F-3F3B34E831FB=2=id-ID=Normal.png',
    'types' => [
      ['name' => 'Private', 'price' => 20000],
    ],
  ],
  [
    'id' => 11,
    'name' => 'Viu Premium',
    'price' => 25000,
    'category' => 'Streaming',
    'rating' => 4.6,
    'tag' => 'Limited',
    'img' => 'https://assets.telkomsel.com/public/2025-01/Cara-Termudah-Langganan-Viu-Hanya-Beberapa-Kali-Klik.jpg?VersionId=ad410H.OkX24LobObo2I.JqmL.TrtfS_',
    'types' => [
      ['name' => '1 Tahun', 'price' => 25000],
    ],
	],
  [
    'id' => 12,
    'name' => 'GetContact',
    'price' => 25000,
    'category' => 'Tools',
    'rating' => 4.6,
    'tag' => 'Limited',
    'img' => 'https://assets.telkomsel.com/public/2025-01/getcontact-web.jpg?VersionId=_7OaEFwaJ5c0nL75wOMu4SIyBCvCxNFp_',
    'types' => [
      ['name' => '1 Bulan', 'price' => 25000],
    ],
	],
  [
    'id' => 13,
    'name' => 'Alight Motion',
    'price' => 27000,
    'category' => 'Tools',
    'rating' => 4.6,
    'tag' => 'Limited',
    'img' => 'https://is1-ssl.mzstatic.com/image/thumb/Purple211/v4/b7/7b/b7/b77bb792-30b0-3e4f-4106-13785586d1d9/AppIcon-0-0-1x_U007emarketing-0-5-0-0-0-0-85-220.png/1200x630wa.png_',
    'types' => [
      ['name' => '1 Tahun', 'price' => 27000],
    ],
	],
  [
    'id' => 14,
    'name' => 'Turnitin',
    'price' => 35000,
    'category' => 'Tools',
    'rating' => 4.8,
    'tag' => 'Limited',
    'img' => 'https://cdn-1.webcatalog.io/catalog/turnitin/turnitin-social-preview.png?v=1714776263246_',
    'types' => [
      ['name' => '1 Bulan', 'price' => 35000],
	  ['name' => '2 Bulan', 'price' => 55000],
	  ['name' => '3 Bulan', 'price' => 70000],
    ],
  ],
];

// 3) HELPER & PERSIAPAN
function currency_idr($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

// Daftar kategori unik
$categories = array_values(array_unique(array_map(fn($p)=>$p['category'], $products)));
array_unshift($categories, 'Semua');

// Fallback: jika ada produk tanpa 'types', isi default dari 'price'
foreach ($products as &$p) {
  if (!isset($p['types']) || !is_array($p['types']) || !count($p['types'])) {
    $p['types'] = [ ['name' => 'Default', 'price' => $p['price']] ];
  }
}
unset($p);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($storeName) ?> — Katalog Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{ --bg:#f8fafc; --card:#ffffff; --border:#e5e7eb; --muted:#6b7280; --fg:#0f172a; --primary:#6d28d9; --primary2:#db2777; }
    *{box-sizing:border-box}
    html,body{margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Helvetica Neue",Arial,sans-serif;color:var(--fg);background:linear-gradient(#fff,var(--bg));}
    a{text-decoration:none;color:inherit}
    .container{max-width:1120px;margin:0 auto;padding:0 20px}
    .nav{position:sticky;top:0;backdrop-filter:saturate(180%) blur(8px);background:rgba(255,255,255,.7);border-bottom:1px solid var(--border);z-index:50}
    .nav-inner{display:flex;align-items:center;justify-content:space-between;padding:12px 0}
    .brand{display:flex;align-items:center;gap:10px;font-weight:700}
    .brand-badge{width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,var(--primary),var(--primary2));}
    .btn{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--border);background:#fff;padding:10px 14px;border-radius:12px;font-weight:600;cursor:pointer;transition:.2s}
    .btn.primary{background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;border:none}
    .btn:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(0,0,0,.06)}
    header.hero{position:relative;overflow:hidden}
    .blob{position:absolute;filter:blur(40px);opacity:.5}
    .blob.one{top:-60px;left:-60px;width:220px;height:220px;background:radial-gradient(circle at 30% 30%, #818cf8, transparent 60%), radial-gradient(circle at 70% 70%, #f472b6, transparent 60%)}
    .blob.two{bottom:-80px;right:-100px;width:320px;height:320px;background:radial-gradient(circle at 40% 40%, #34d399, transparent 60%), radial-gradient(circle at 60% 60%, #60a5fa, transparent 60%)}
    .hero-inner{display:grid;grid-template-columns:1.1fr 1fr;gap:36px;align-items:center;padding:72px 0}
    .badge{display:inline-flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--border);padding:6px 10px;border-radius:999px;font-size:13px;color:#111}
    h1{font-size:40px;line-height:1.1;margin:14px 0 8px}
    .gradient-text{background:linear-gradient(135deg,var(--primary),var(--primary2));-webkit-background-clip:text;background-clip:text;color:transparent}
    .muted{color:var(--muted)}
    .hero-img{position:relative;border-radius:22px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.15)}
    .hero-card{position:absolute;left:18px;right:18px;bottom:-18px;background:#fff;border:1px solid var(--border);padding:14px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.12)}
    section{padding:72px 0}
    .grid{display:grid;gap:18px}
    .grid-3{grid-template-columns:repeat(3,1fr)}
    .grid-2{grid-template-columns:repeat(2,1fr)}
    .card{background:var(--card);border:1px solid var(--border);border-radius:20px;overflow:hidden}
    .card .p{padding:18px}
    .product-img{aspect-ratio:4/3;width:100%;object-fit:cover;display:block;transition:transform .5s}
    .card:hover .product-img{transform:scale(1.04)}
    .pill{display:inline-block;padding:6px 10px;border-radius:999px;background:#fff;border:1px solid var(--border);font-size:12px}
    .price{font-weight:700}
    .tools{display:flex;gap:10px;flex-wrap:wrap}
    select,input[type="search"]{height:42px;padding:0 14px;border:1px solid var(--border);border-radius:12px;background:#fff}
    .features{display:grid;gap:18px}
    .feature{display:flex;gap:12px;align-items:flex-start;border:1px solid var(--border);padding:16px;border-radius:16px;background:#fff}
    .testi-row{display:flex;gap:16px;overflow:auto;scrollbar-width:none}
    .testi-row::-webkit-scrollbar{display:none}
    .testi{min-width:300px}
    .faq details{background:#fff;border:1px solid var(--border);border-radius:14px;padding:12px}
    .faq summary{cursor:pointer;font-weight:600}
    .cta{background:linear-gradient(135deg,var(--primary),var(--primary2));color:#fff;border-radius:22px}
    .cta .p{padding:24px}
    footer{border-top:1px solid var(--border);padding:24px 0}
    .floating-wa{position:fixed;right:18px;bottom:18px;z-index:60}
    .scrolltop{position:fixed;left:18px;bottom:18px;z-index:60}
    .icon{display:inline-grid;place-items:center;width:28px;height:28px;border-radius:8px;background:#f1f5f9;margin-right:6px}

    @media (max-width:900px){ .hero-inner{grid-template-columns:1fr} .grid-3{grid-template-columns:1fr 1fr} }
    @media (max-width:640px){ .grid-3,.grid-2{grid-template-columns:1fr} h1{font-size:32px} }
  </style>
</head>
<body>
  <!-- NAV -->
  <nav class="nav">
    <div class="container nav-inner">
      <div class="brand">
        <div class="brand-badge"></div>
        <span><?= htmlspecialchars($storeName) ?></span>
      </div>
      <div class="tools">
        <a class="btn" href="#produk">Produk</a>
        <a class="btn" href="#faq">FAQ</a>
        <a class="btn primary" target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>?text=<?= rawurlencode('Halo, saya butuh bantuan memilih produk.') ?>">Hubungi Kami</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header class="hero">
    <div class="blob one"></div>
    <div class="blob two"></div>
    <div class="container hero-inner">
      <div>
        <div class="badge">✨ Diskon spesial bulan ini</div>
        <h1>Jelajahi <span class="gradient-text">Produk Pilihan</span> Kami</h1>
        <p class="muted"><?= htmlspecialchars($tagline) ?>. Temukan kebutuhan harian dan hadiah spesial dalam sekali klik.</p>
        <div class="tools" style="margin-top:14px">
          <a class="btn primary" href="#produk">🛍️ Lihat Produk</a>
          <a class="btn" target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>?text=<?= rawurlencode('Halo, saya ingin konsultasi produk.') ?>">📞 Konsultasi Gratis</a>
        </div>
        <div class="muted" style="margin-top:10px;display:flex;gap:16px;font-size:14px">
          <span>✅ Garansi Kepuasan</span>
          <span>🚚 Pengiriman Cepat</span>
        </div>
      </div>
      <div class="hero-img">
        <img src="https://i.postimg.cc/MH7dppYZ/M-600-x-500-px.png" alt="Hero" style="width:100%;display:block">
        <div class="hero-card">
          <strong>★★★★★</strong>
          <div class="muted" style="font-size:14px">Lebih dari 2.000 pelanggan puas bulan ini</div>
        </div>
      </div>
    </div>
  </header>

  <!-- HIGHLIGHTS -->
  <section>
    <div class="container features grid-3">
      <div class="feature"><span class="icon">🛡️</span>
        <div><strong>Produk Terjamin</strong><div class="muted">Kontrol kualitas ketat setiap batch.</div></div>
      </div>
      <div class="feature"><span class="icon">🚚</span>
        <div><strong>Pengiriman Cepat</strong><div class="muted">Order < 15.00 kirim di hari yang sama*.</div></div>
      </div>
      <div class="feature"><span class="icon">💸</span>
        <div><strong>Banyak Promo</strong><div class="muted">Diskon spesial & bundling hemat.</div></div>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section id="produk">
    <div class="container">
      <div style="display:flex;align-items:end;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:16px">
        <div>
          <h2 style="margin:0 0 6px 0">Daftar Produk</h2>
          <div class="muted">Pilih kategori, cari produk, dan pesan langsung.</div>
        </div>
        <div class="tools">
          <input type="search" id="q" placeholder="Cari produk..." />
          <select id="cat">
            <?php foreach ($categories as $c): ?>
              <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div id="product-grid" class="grid grid-3">
        <?php foreach ($products as $p): ?>
          <?php $defaultType = $p['types'][0]; ?>
          <div class="card product" data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>" data-cat="<?= htmlspecialchars($p['category']) ?>">
            <div style="position:relative">
              <img class="product-img" src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"/>
              <div style="position:absolute;left:12px;top:12px" class="pill"><?= htmlspecialchars($p['tag']) ?></div>
            </div>
            <div class="p">
              <div style="font-weight:600"><?= htmlspecialchars($p['name']) ?></div>
              <div class="muted" style="display:flex;gap:8px;align-items:center;margin-top:4px">
                <span class="price" data-base-price="<?= (int)$defaultType['price'] ?>"><?= currency_idr($defaultType['price']) ?></span>
                <span>•</span>
                <span class="muted">Rating <?= number_format($p['rating'],1) ?></span>
              </div>

              <?php if (!empty($p['types'])): ?>
                <div style="margin-top:10px">
                  <label for="type-<?= (int)$p['id'] ?>" class="muted" style="font-size:13px;display:block;margin-bottom:6px">Pilih tipe</label>
                  <select class="type-select" id="type-<?= (int)$p['id'] ?>" style="width:100%;max-width:240px">
                    <?php foreach ($p['types'] as $t): ?>
                      <option value="<?= htmlspecialchars($t['name']) ?>" data-price="<?= (int)$t['price'] ?>">
                        <?= htmlspecialchars($t['name']) ?> — <?= currency_idr($t['price']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              <?php endif; ?>

              <?php
                $initMsg = rawurlencode('Halo, saya mau pesan: ' . $p['name'] . ' - Tipe: ' . $defaultType['name'] . ' (' . currency_idr($defaultType['price']) . ').');
              ?>
              <div class="tools" style="margin-top:12px">
                <a class="btn primary wa-link" target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>?text=<?= $initMsg ?>">Pesan via WhatsApp</a>
                <button class="btn" onclick="alert('Detail: <?= htmlspecialchars($p['name']) ?>')">Detail</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div id="empty" class="muted" style="text-align:center;margin-top:16px;display:none">Tidak ada produk yang cocok dengan pencarian.</div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section>
    <div class="container">
      <div style="text-align:center;margin-bottom:16px">
        <h2 style="margin:0 0 6px 0">Apa kata mereka</h2>
        <div class="muted">Ulasan nyata dari pelanggan kami.</div>
      </div>
      <div class="testi-row">
        <?php foreach ([
          'Cepat sampai dan kualitas oke!',
          'Adminnya ramah dan responsif.',
          'Harga bersahabat dan bergaransi.',
          'Produk original dan aman.'
        ] as $t): ?>
          <div class="card testi"><div class="p">
            <div style="font-weight:600">★★★★★</div>
            <div class="muted"><?= htmlspecialchars($t) ?></div>
          </div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq">
    <div class="container faq" style="max-width:760px">
      <div style="text-align:center;margin-bottom:16px">
        <h2 style="margin:0 0 6px 0">Pertanyaan Umum</h2>
        <div class="muted">Jika masih ragu, langsung tanya via WhatsApp ya!</div>
      </div>
      <details><summary>Bagaimana cara pemesanan?</summary><div class="muted">Pilih produk, klik "Pesan via WhatsApp". Pesan akan otomatis terisi.</div></details>
      <div style="height:8px"></div>
      <details><summary>Apakah ada Garansi?</summary><div class="muted">Tersedia garansi untuk semua produk. Hubungi admin untuk cek garansi</div></details>
      <div style="height:8px"></div>
      <details><summary>Berapa lama pengiriman?</summary><div class="muted">Regular 10-45 Menit tergantung Ketersediaan.</div></details>
    </div>
  </section>

  <!-- CTA -->
  <section>
    <div class="container cta card">
      <div class="p" style="text-align:center">
        <h2 style="margin-top:0">Siap Belanja Hemat Hari Ini?</h2>
        <div class="muted">Tanya stok & promo terbaru langsung ke admin.</div>
        <div style="margin-top:12px">
          <a class="btn" style="background:#fff;color:#111" target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>?text=<?= rawurlencode('Halo admin, saya mau tanya stok & promo ya.') ?>">💬 Chat WhatsApp Sekarang</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
      <div class="muted">© <?= date('Y') ?> <?= htmlspecialchars($storeName) ?> • All rights reserved</div>
      <div class="muted" style="display:flex;gap:10px">
        <a href="#produk">Produk</a><span>•</span>
        <a target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>">WhatsApp</a>
      </div>
    </div>
  </footer>

  <!-- FLOATING BUTTONS -->
  <a class="btn primary floating-wa" target="_blank" rel="noreferrer" href="https://wa.me/<?= $whatsapp ?>?text=<?= rawurlencode('Halo, saya tertarik dengan produk Anda.') ?>">📱 Chat WhatsApp</a>
  <button class="btn scrolltop" onclick="window.scrollTo({top:0,behavior:'smooth'})">⬆️ Ke atas</button>

  <script>
    // Pencarian & Filter Kategori (tanpa framework)
    const q = document.getElementById('q');
    const cat = document.getElementById('cat');
    const grid = document.getElementById('product-grid');
    const empty = document.getElementById('empty');

    function applyFilter(){
      const term = (q.value||'').trim().toLowerCase();
      const c = cat.value;
      let visible = 0;
      for(const item of grid.querySelectorAll('.product')){
        const name = item.dataset.name;
        const icat = item.dataset.cat;
        const inQ = term === '' || name.includes(term);
        const inC = c === 'Semua' || icat === c;
        const show = inQ && inC;
        item.style.display = show ? '' : 'none';
        if(show) visible++;
      }
      empty.style.display = visible ? 'none' : '';
    }
    q.addEventListener('input', applyFilter);
    cat.addEventListener('change', applyFilter);

    // Tipe produk: sinkronkan harga & link WA
    function formatIDR(n){
      return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(n);
    }

    function initTypeSelectors(){
      document.querySelectorAll('.product').forEach(card => {
        const priceEl = card.querySelector('.price');
        const waLink  = card.querySelector('.wa-link');
        const nameEl  = card.querySelector('.p > div');
        const name    = nameEl ? nameEl.textContent.trim() : '';
        const select  = card.querySelector('.type-select');
        if(!select) return; // produk tanpa tipe

        function update(){
          const opt       = select.selectedOptions[0];
          const typeName  = opt?.value || '';
          const typePrice = +(opt?.dataset.price || priceEl?.dataset?.basePrice || 0);
          // Update harga display
          if(priceEl) priceEl.textContent = formatIDR(typePrice);
          // Update link WA
          if(waLink){
            const msg = `Halo, saya mau pesan: ${name} - Tipe: ${typeName} (${formatIDR(typePrice)}).`;
            waLink.href = `https://wa.me/<?= $whatsapp ?>?text=${encodeURIComponent(msg)}`;
          }
        }
        select.addEventListener('change', update);
        update(); // inisialisasi awal
      });
    }
    initTypeSelectors();

    // Animasi sederhana untuk blob
    let t=0; const b1=document.querySelector('.blob.one'), b2=document.querySelector('.blob.two');
    function animate(){
      t+=0.01; if(b1){b1.style.transform=`translate(${Math.sin(t)*6}px, ${Math.cos(t)*6}px)`}
      if(b2){b2.style.transform=`translate(${Math.cos(t)*8}px, ${Math.sin(t)*8}px)`}
      requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);
  </script>
</body>
</html>