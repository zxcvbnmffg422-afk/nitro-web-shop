<?php
/**
 * ملف: tt.php
 * الوصف: صفحة "دليل الاستخدام" — تُفتح كـ Telegram Web App من زر
 *         "📖 دليل الاستخدام" داخل البوت.
 *
 * الاستقبال (اختياري):
 *   يستقبل الصفحة معرّف المستخدم عبر ?id=123456789 (نفس الباراميتر
 *   المرسل من زر الـ web_app بالبوت) لعرضه إن رغبت مستقبلاً بتخصيص
 *   المحتوى حسب المستخدم.
 */
$uid = isset($_GET['id']) ? preg_replace('/[^0-9]/', '', $_GET['id']) : '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>دليل الاستخدام</title>
<script src="https://telegram.org/js/telegram-web-app.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#0E1120;
    --bg-2:#151A30;
    --surface:#1B2140;
    --surface-2:#232B4E;
    --line:rgba(255,255,255,0.08);
    --line-strong:rgba(255,255,255,0.14);
    --gold:#F2B84B;
    --gold-dim:rgba(242,184,75,0.16);
    --teal:#34D1BF;
    --teal-dim:rgba(52,209,191,0.14);
    --text:#EDEFF7;
    --text-dim:#9498B3;
    --text-faint:#5D6180;
    --radius:18px;
  }
  *{box-sizing:border-box;-webkit-tap-highlight-color:transparent;}
  html,body{margin:0;padding:0;}
  body{
    background:
      radial-gradient(circle at 12% 0%, rgba(242,184,75,0.10), transparent 45%),
      radial-gradient(circle at 88% 18%, rgba(52,209,191,0.08), transparent 40%),
      var(--bg);
    color:var(--text);
    font-family:'Tajawal',sans-serif;
    min-height:100vh;
    padding-bottom:110px;
  }
  .mono{font-family:'JetBrains Mono',monospace;}

  /* ================= الهيدر ================= */
  header{
    padding:28px 20px 22px;
    text-align:center;
    position:relative;
  }
  header .eyebrow{
    font-size:12px;
    color:var(--gold);
    letter-spacing:.5px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:var(--gold-dim);
    padding:5px 14px;
    border-radius:999px;
    margin-bottom:14px;
  }
  header h1{
    font-size:23px;
    font-weight:900;
    margin:0 0 8px;
    line-height:1.4;
  }
  header p{
    font-size:14px;
    color:var(--text-dim);
    margin:0;
    line-height:1.8;
    max-width:320px;
    margin-inline:auto;
  }

  /* ============ إحصاء سريع (بار تقدم رمزي) ============ */
  .progress-strip{
    display:flex;
    gap:4px;
    padding:0 20px 26px;
  }
  .progress-strip span{
    flex:1;
    height:3px;
    border-radius:3px;
    background:var(--line);
  }
  .progress-strip span.active{background:var(--gold);}

  /* ================= خط السير (Signature) ================= */
  .rail-wrap{
    padding:0 20px;
    position:relative;
  }
  .step{
    display:flex;
    gap:16px;
    position:relative;
    padding-bottom:26px;
  }
  .step:last-child{padding-bottom:0;}
  .step .line{
    position:absolute;
    top:34px;
    bottom:-2px;
    right:17px;
    width:2px;
    background:var(--line);
  }
  .step:last-child .line{display:none;}
  .marker{
    flex-shrink:0;
    width:36px;
    height:36px;
    border-radius:50%;
    background:var(--surface);
    border:1px solid var(--line-strong);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'JetBrains Mono',monospace;
    font-weight:500;
    font-size:14px;
    color:var(--text-dim);
    position:relative;
    z-index:1;
  }
  .marker.gold{
    background:var(--gold-dim);
    border-color:var(--gold);
    color:var(--gold);
  }
  .marker.teal{
    background:var(--teal-dim);
    border-color:var(--teal);
    color:var(--teal);
  }
  .card{
    flex:1;
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:var(--radius);
    overflow:hidden;
  }
  .card summary{
    list-style:none;
    cursor:pointer;
    padding:14px 16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
  }
  .card summary::-webkit-details-marker{display:none;}
  .card summary h3{
    font-size:15px;
    font-weight:700;
    margin:0;
    line-height:1.5;
  }
  .chev{
    flex-shrink:0;
    width:22px;
    height:22px;
    color:var(--text-faint);
    transition:transform .25s ease;
  }
  details[open] .chev{transform:rotate(180deg);}
  .card .body{
    padding:0 16px 16px;
    color:var(--text-dim);
    font-size:13.5px;
    line-height:2;
  }
  .card .body ul{margin:0;padding:0;list-style:none;}
  .card .body li{
    position:relative;
    padding-inline-end:16px;
    margin-bottom:8px;
  }
  .card .body li::before{
    content:'';
    position:absolute;
    top:9px;
    right:0;
    width:5px;
    height:5px;
    border-radius:50%;
    background:var(--gold);
  }
  .card .body li:last-child{margin-bottom:0;}
  .tag{
    display:inline-block;
    font-size:11px;
    font-weight:700;
    padding:2px 9px;
    border-radius:999px;
    margin-top:10px;
  }
  .tag.gold{background:var(--gold-dim);color:var(--gold);}
  .tag.teal{background:var(--teal-dim);color:var(--teal);}

  /* ================= الأسئلة الشائعة ================= */
  .section-title{
    padding:32px 20px 14px;
    font-size:15px;
    font-weight:700;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:8px;
  }
  .section-title::before{
    content:'';
    width:4px;
    height:16px;
    background:var(--teal);
    border-radius:3px;
  }
  .faq{padding:0 20px;display:flex;flex-direction:column;gap:10px;}
  .faq .card summary h3{font-size:14px;}

  /* ================= شريط التواصل ================= */
  .contact-grid{
    padding:26px 20px 4px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
  }
  .contact-grid a{
    text-decoration:none;
    color:var(--text);
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:14px;
    padding:14px 12px;
    text-align:center;
    display:block;
    font-size:13px;
    font-weight:700;
  }
  .contact-grid a span{
    display:block;
    font-size:20px;
    margin-bottom:6px;
  }

  /* ================= زر ثابت أسفل الشاشة ================= */
  .cta-bar{
    position:fixed;
    bottom:0;
    right:0;
    left:0;
    padding:14px 20px calc(14px + env(safe-area-inset-bottom));
    background:linear-gradient(180deg, transparent, var(--bg) 30%);
  }
  .cta-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    width:100%;
    border:none;
    background:var(--gold);
    color:#241705;
    font-family:'Tajawal',sans-serif;
    font-weight:900;
    font-size:15px;
    padding:15px;
    border-radius:14px;
  }
  .cta-btn:active{opacity:.85;}

  footer{
    text-align:center;
    padding:8px 20px 0;
    color:var(--text-faint);
    font-size:11px;
  }
</style>
</head>
<body>

<header>
  <div class="eyebrow">⚡ دليل الاستخدام</div>
  <h1>كل شي تحتاج تعرفه<br>باستخدام المنصة</h1>
  <p>ست خطوات بسيطة تفصلك عن أول طلب ناجح — تصفحها بالترتيب أو روح مباشرة للي يخصك.</p>
</header>

<div class="progress-strip">
  <span class="active"></span><span class="active"></span><span class="active"></span>
  <span class="active"></span><span class="active"></span><span class="active"></span>
</div>

<div class="rail-wrap">

  <div class="step">
    <div class="line"></div>
    <div class="marker gold">01</div>
    <details class="card" open>
      <summary>
        <h3>البداية — فتح المنصة</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>اضغط زر <b style="color:var(--text)">دخول المنصة الآن</b> من رسالة البوت الرئيسية.</li>
          <li>تنفتح واجهة المتجر مباشرة داخل تيليجرام، بدون تحميل تطبيق.</li>
          <li>تصفح الأقسام والفئات لين تلكى الخدمة المطلوبة.</li>
        </ul>
        <span class="tag gold">يستغرق أقل من دقيقة</span>
      </div>
    </details>
  </div>

  <div class="step">
    <div class="line"></div>
    <div class="marker">02</div>
    <details class="card">
      <summary>
        <h3>شحن الرصيد</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>حوّل المبلغ عن طريق وسيلة الدفع المتوفرة بالمنصة.</li>
          <li>دز <b style="color:var(--text)">صورة وصل التحويل</b> بشات البوت مباشرة، بدون أي وصف إضافي.</li>
          <li>تتم مراجعة الوصل وإضافة الرصيد خلال دقائق.</li>
          <li>توصلك رسالة تأكيد فور إضافة الرصيد لحسابك.</li>
        </ul>
        <span class="tag teal">مراجعة سريعة</span>
      </div>
    </details>
  </div>

  <div class="step">
    <div class="line"></div>
    <div class="marker">03</div>
    <details class="card">
      <summary>
        <h3>تنفيذ الطلب</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>اختر الخدمة من داخل المتجر وحدد الكمية أو الباقة.</li>
          <li>تأكد من صحة البيانات المدخلة (الحساب، الرابط، الرقم...) قبل التأكيد.</li>
          <li>اضغط تأكيد، ينخصم المبلغ من رصيدك تلقائيًا ويبدأ التنفيذ.</li>
        </ul>
      </div>
    </details>
  </div>

  <div class="step">
    <div class="line"></div>
    <div class="marker teal">04</div>
    <details class="card">
      <summary>
        <h3>نظام الإحالة والأرباح</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>اضغط <b style="color:var(--text)">رابط إحالتي الشخصي</b> بالقائمة الرئيسية.</li>
          <li>شارك الرابط مع أصدقائك أو بمجموعاتك.</li>
          <li>كل شخص ينضم عن طريقك يُحسب ضمن إحالاتك تلقائيًا.</li>
          <li>تربح عمولة عن نشاط كل إحالة، تُضاف مباشرة لرصيدك.</li>
        </ul>
        <span class="tag gold">دخل إضافي</span>
      </div>
    </details>
  </div>

  <div class="step">
    <div class="line"></div>
    <div class="marker">05</div>
    <details class="card">
      <summary>
        <h3>متابعة حسابك</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>رصيدك الحالي وعدد طلباتك المنجزة يظهرون بأعلى الرسالة الرئيسية.</li>
          <li>عدد إحالاتك يتحدث تلقائيًا مع كل عضو جديد ينضم عن طريقك.</li>
          <li>ارجع بأي وقت للقائمة الرئيسية عن طريق زر الرجوع.</li>
        </ul>
      </div>
    </details>
  </div>

  <div class="step">
    <div class="marker">06</div>
    <details class="card">
      <summary>
        <h3>الدعم والمساعدة</h3>
        <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </summary>
      <div class="body">
        <ul>
          <li>عندك استفسار أو مشكلة؟ تواصل مع الدعم الفني بأي وقت.</li>
          <li>تابع قناة التحديثات حتى توصلك آخر العروض والمزايا الجديدة أول بأول.</li>
        </ul>
      </div>
    </details>
  </div>

</div>

<div class="section-title">الأسئلة الشائعة</div>
<div class="faq">
  <details class="card">
    <summary>
      <h3>شكد يحتاج وقت شحن الرصيد؟</h3>
      <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </summary>
    <div class="body">عادة يتم تأكيد الوصل وإضافة الرصيد خلال دقائق من إرساله، وبأوقات الذروة قد يتأخر شوي.</div>
  </details>
  <details class="card">
    <summary>
      <h3>ليش طلبي متأخر؟</h3>
      <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </summary>
    <div class="body">بعض الخدمات تحتاج وقت تنفيذ أطول حسب نوعها. إذا تأخر أكثر من المعتاد، تواصل مع الدعم الفني مباشرة.</div>
  </details>
  <details class="card">
    <summary>
      <h3>كيف أسحب أرباح الإحالة؟</h3>
      <svg class="chev" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </summary>
    <div class="body">أرباح الإحالة تُضاف مباشرة لرصيدك وتقدر تستخدمها بأي طلب بنفس المنصة.</div>
  </details>
</div>

<div class="contact-grid">
  <a href="https://t.me/YourSupport"><span>💬</span>الدعم الفني</a>
  <a href="https://t.me/YourChannel"><span>📢</span>قانة التحديثات</a>
</div>

<footer>
  <?php if ($uid): ?>
  معرّفك: <span class="mono"><?= htmlspecialchars($uid) ?></span>
  <?php endif; ?>
</footer>

<div class="cta-bar">
  <button class="cta-btn" onclick="closeGuide()">
    فهمت، رجعني للبوت ⚡
  </button>
</div>

<script>
  const tg = window.Telegram?.WebApp;
  if (tg) {
    tg.ready();
    tg.expand();
    try { tg.setHeaderColor('#0E1120'); } catch(e){}
    try { tg.setBackgroundColor('#0E1120'); } catch(e){}
  }

  function closeGuide(){
    const botLink = 'https://t.me/F_LABOT';
    if (tg) {
      tg.openTelegramLink(botLink);
      tg.close();
    } else {
      window.location.href = botLink;
    }
  }
</script>

</body>
</html>
