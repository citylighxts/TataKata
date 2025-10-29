<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title }}</title>
  <style>
    @page { margin: 24px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; color:#111; }
    h1 { font-size: 18px; margin: 0 0 8px; }
    .meta { font-size: 10px; color:#666; margin-bottom: 12px; }
    .content p { margin: 0 0 8px; }
  </style>
</head>
<body>
  <h1>Hasil Koreksi — {{ $title }}</h1>
  <div class="meta">Diunduh: {{ now()->format('d M Y H:i') }}</div>
  <div class="content">{!! $html !!}</div>
</body>
</html>
