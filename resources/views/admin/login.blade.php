<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — SI-BERSIH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg: #EEF2ED;
    --card: #FFFFFF;
    --ink: #1C2620;
    --ink-soft: #5B6660;
    --line: #DADFD8;
    --green: #2F6D4F;
    --green-soft: #E4EFE8;
    --rust: #B14A3A;
    --display: 'Fraunces', serif;
    --sans: 'IBM Plex Sans', sans-serif;
    --mono: 'IBM Plex Mono', monospace;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    background:var(--bg);
    color:var(--ink);
    font-family:var(--sans);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
  }
  .login-container{
    width:100%;
    max-width:360px;
  }
  .brand-center{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:12px;
    margin-bottom:32px;
    text-align:center;
  }
  .brand-center .mark{
    width:44px;
    height:44px;
    border-radius:10px;
    background:var(--green);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:var(--display);
    font-weight:600;
    font-size:20px;
  }
  .brand-center h1{
    font-family:var(--display);
    font-weight:600;
    font-size:24px;
    margin:0;
  }
  .brand-center span{
    font-size:12px;
    color:var(--ink-soft);
    margin-top:2px;
  }
  .board{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:16px;
    padding:28px 24px;
    box-shadow:0 4px 20px rgba(28,38,32,.04);
  }
  .board h2{
    font-family:var(--display);
    font-size:18px;
    margin:0 0 20px;
    font-weight:600;
    text-align:center;
  }
  .form-group{
    margin-bottom:18px;
  }
  .field-label{
    font-size:12px;
    color:var(--ink-soft);
    margin:0 0 6px;
    font-weight:500;
  }
  .input-style{
    width:100%;
    background:var(--card);
    border:1px solid var(--line);
    border-radius:10px;
    padding:11px 12px;
    font-size:13px;
    color:var(--ink);
    font-family:var(--sans);
  }
  .input-style:focus{
    border-color:var(--green);
    outline:none;
    box-shadow:0 0 0 3px var(--green-soft);
  }
  .btn-primary{
    width:100%;
    background:var(--green);
    color:#fff;
    text-align:center;
    padding:13px;
    border-radius:10px;
    font-weight:500;
    font-size:14px;
    border:none;
    cursor:pointer;
    font-family:var(--sans);
    margin-top:6px;
  }
  .btn-primary:hover{
    opacity:.9;
  }
  .error-message{
    color:var(--rust);
    font-family:var(--mono);
    font-size:11px;
    margin-top:6px;
  }
  .hint{
    font-size:11px;
    color:var(--ink-soft);
    text-align:center;
    margin-top:20px;
  }
</style>
</head>
<body>

<div class="login-container">

  <!-- Logo dan Identitas Aplikasi -->
  <div class="brand-center">
    <div class="mark">SB</div>
    <div>
      <h1>SI-BERSIH</h1>
      <span>Monitoring &amp; akuntabilitas kebersihan sekolah</span>
    </div>
  </div>

  
  <div class="board">
    <h2>Masuk ke Akun</h2>

    <form action={{ route('admin.login') }} method="POST">
      @csrf 

      <!-- Input Email -->
      <div class="form-group">
        <p class="field-label">Alamat Email</p>
        <input type="email" name="email" class="input-style" value="{{ old('email') }}" required autofocus placeholder="nama@sekolah.sch.id">
        @error('email')
          <div class="error-message">✕ {{ $message }}</div>
        @enderror
      </div>

      <!-- Input Password -->
      <div class="form-group">
        <p class="field-label">Password Akun</p>
        <input type="password" name="password" class="input-style" required placeholder="••••••••">
        @error('password')
          <div class="error-message">✕ {{ $message }}</div>
        @enderror
      </div>

      <!-- Tombol Submit -->
      <button type="submit" class="btn-primary">Masuk Sekarang</button>
    </form>

    <div class="hint">Hubungi admin sarpras jika Anda lupa data kredensial akses login Anda.</div>
  </div>

</div>

</body>
</html>
