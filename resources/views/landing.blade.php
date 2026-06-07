<!doctype html><!-- DEPRECATED: moved to home.blade.php -->

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Estilo Jalisco</title>
    <style>
        :root {
            --brand-orange: #ed8a23;
            --brand-gold: #f7c600;
            --brand-green: #1d7d32;
        }
        html,body { height:100%; margin:0 }
        body { font-family: 'Instrument Sans', Arial, Helvetica, sans-serif; background: #ffffff; color:#111 }
        .hero { display:flex; align-items:center; justify-content:space-between; gap:2rem; padding:6rem 4rem; max-width:1200px; margin:0 auto }
        .hero .left { flex:1 }
        .hero h1 { font-size:3.2rem; line-height:1.02; margin:0 0 1rem; font-weight:800 }
        .hero p.lead { color:#555; margin:0 0 1.5rem }
        .btn-brand {
            display:inline-block; padding:0.9rem 1.6rem; background:var(--brand-orange); color:#fff; border-radius:40px; text-decoration:none; font-weight:700; box-shadow:0 10px 30px rgba(237,138,35,0.18);
        }
        .hero .right { width:420px; display:flex; align-items:center; justify-content:center }
        .dish-card { background: #fff; border-radius:12px; padding:0.75rem; box-shadow:0 8px 24px rgba(0,0,0,0.08); width:160px; text-align:left }
        @media (max-width:900px) { .hero { flex-direction:column; padding:3rem 1.5rem } .hero .right{ width:100% } .hero h1{font-size:2rem} }
    </style>
</head>
<body>
    <div class="hero">
        <div class="left">
            <small style="display:inline-block; background:rgba(237,138,35,0.08); color:var(--brand-orange); padding:6px 10px; border-radius:999px; font-weight:700; font-size:0.8rem">WELCOME TO OUR RESTAURANT</small>
            <h1>Your Go-To Spot For Great <span style="color:var(--brand-orange)">Food</span> And <span style="color:var(--brand-orange)">Good Times</span></h1>
            <p class="lead">Join us for delicious meals and memorable moments — order online for pickup or delivery.</p>
            <a href="{{ route('menu') }}" class="btn-brand">Order Now</a>
        </div>
        <div class="right">
            <div style="display:flex;gap:12px;flex-direction:column;align-items:center">
                <img src="/public/storage/placeholder-dish.jpg" alt="Dish" style="width:320px; border-radius:18px; box-shadow:0 16px 40px rgba(0,0,0,0.08); object-fit:cover;">
                <div style="display:flex;gap:10px;margin-top:12px">
                    <div class="dish-card">
                        <strong>Salad Special</strong>
                        <div style="color:#f7c600; margin-top:6px">★ 5.0</div>
                    </div>
                    <div class="dish-card">
                        <strong>Good For Health</strong>
                        <div style="color:#f7c600; margin-top:6px">★ 5.0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
