<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title }}</title>
  <style>
    @page { margin: 24px; }
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      line-height: 1.5;
      color: #111;
    }
    h1 {
      font-size: 18px;
      margin-bottom: 10px;
    }
    .meta {
      font-size: 10px;
      color: #666;
      margin-bottom: 14px;
    }
    p {
      margin: 4px 0;
      text-align: justify;
    }
    ul, ol {
      margin: 4px 0 6px 20px;
      padding-left: 16px;
    }
    li {
      margin: 2px 0;
    }
    hr {
      border: none;
      height: 1px;
      background: #ddd;
      margin: 8px 0;
    }
    pre {
      background: #f7f7f7;
      padding: 6px;
      border-radius: 4px;
      font-size: 11px;
    }
  </style>
</head>
<body>
  <h1>Hasil Koreksi — {{ $title }}</h1>
  <div class="meta">Diunduh: {{ now()->format('d M Y H:i') }}</div>

  {{-- Gunakan {!! !!} agar HTML di teks tetap muncul --}}
  {!! nl2br(e($corrected_text)) !!}
</body>
</html>
