  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ siteSetting('site_name') }}</title>
    <link rel="icon" href="{{ asset('storage/' . siteSetting('site_favicon')) }}" type="image/x-icon" />
    @vite(['resources/css/app.css'])
    <style>
      @import url(https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap);
      @import url(https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined);
      @import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css);
    </style>
  </head>
