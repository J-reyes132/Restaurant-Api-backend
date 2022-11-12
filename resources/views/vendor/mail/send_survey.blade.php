<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,800&display=swap"
      rel="stylesheet"
    />
    <title>Template</title>
  </head>

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: "Open Sans", sans-serif;
      line-height: 30px;
    }

    .container {
      box-shadow: 2px 2px 2px 2px #e2e2e2;
      border: 1 solid;
      padding: 30px;
      width: 100%;
    }

    .title,
    .link  {
      color: #004e9e;
      margin-bottom: 20px;
    }

    .link {
      border-color: #004e9e;
      font-weight: 800;
      overflow: auto;
    }

    .title-link,
    .description {
      color: #6d6c6c;
      margin-bottom: 8px;
      margin-top: 40px;
    }

    hr.divider {
      margin-top: 30px;
      margin-bottom: 30px;
      border: 1 solid #d1d1d1;
    }

    .list {
      display: flex;
      list-style-type: none;
    }

    .due-date {
      display: flex;
      align-items: center;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .text-due-date {
      color: #6d6c6c;
      font-weight: bold;
      font-size: 16px;
    }

    li div {
      text-align: center;
      margin-top: 5px;
      font-size: 12px;
      color: #6d6c6c;
    }

    li p {
      padding: 20px;
      font-size: 30px;
      margin-left: 15px;
      margin-right: 15px;
      border-radius: 50px;
      margin-top: 0;
      margin-bottom: 0;
      text-decoration: none;
      list-style-type: none;
      font-weight: bold;
      color: white;
      background-color: #72b110;
    }
  </style>

  <body>
    <div class="container">
      <h2 class="title">{{ $institution_name }},</h2>
      <p class="description">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry's standard dummy text ever
        since the 1500s, when an unknown printer took a galley of type and
        scrambled it to make a type specimen book. It has survived not only five
        centuries, but also the leap into electronic typesetting, remaining
        essentially unchanged.
      </p>
      <p class="title-link">
        Para acceder a la encuesta correspondiente al mes de abril pulse el
        enlace adjunto:
      </p>

      <p style="overflow: auto;">
        <a class="link" target="_blank" href="{{ $url }}">
          {{ $url }}
        </a>
      </p>

      <hr class="divider" />

      <div class="due-date">
        <p class="text-due-date">Esta encuenta cerrará en:</p>
        <ul class="list">
          <li>
            <p>{{ isset($remaining_time) ? $remaining_time['days'] : '' }}</p>
            <div>DIAS</div>
          </li>
          <li>
            <p>{{ isset($remaining_time) ? $remaining_time['hours'] : '' }}</p>
            <div>HORAS</div>
          </li>
          <li>
            <p>{{ isset($remaining_time) ? $remaining_time['minutes'] : '' }}</p>
            <div>MINUTOS</div>
          </li>
          <li>
            <p>{{ isset($remaining_time) ? $remaining_time['seconds'] : '' }}</p>
            <div>SEGUNDO</div>
          </li>
        </ul>
      </div>

      <hr class="divider" />
      © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    </div>
  </body>
</html>
