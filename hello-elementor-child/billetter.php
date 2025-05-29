 <?php
/**
 * Template Name: Billetter
 * Description: Tilpasset bookingkalender til Lost Dream.
 */
/**OpenAI. (2025). ChatGPT [large language model], https://chatgpt.com/share/6837187b-37b0-800f-857d-98acaf9a18b3 28/05 2025*/
get_header();
?>

<!-- Indlæs Roboto font fra Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
  /* Sæt baggrundsfarve for hele siden */
  html, body {
    background-color: #373737;
    margin: 0;
    padding: 0;
  }

  /* Hovedcontainer med max bredde og centreret */
  main.custom-page-billetter {
    color: #f5f5f5;
    font-family: 'Roboto', sans-serif;
    font-size: 18px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 1140px;
    margin: 0 auto;
  }

  /* Wrapper til CTA-knappen og info-teksten */
  .cta-wrapper {
    margin-bottom: 20px;
    text-align: center;
  }

  /* Styling af call-to-action knappen */
  .cta-button {
    background-color: #FF0032; /* Klar rød */
    color: #f5f5f5;
    font-family: 'Roboto', sans-serif;
    font-size: 19px;
    font-weight: bold;
    padding: 14px 30px;
    border: none;
    border-radius: 999px; /* Maksimal border radius for pill-form */
    cursor: pointer;
    transition: opacity 0.3s ease;
  }

  /* Deaktiveret tilstand for CTA */
  .cta-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  /* Undertekst under CTA-knap */
  .cta-info-text {
    font-size: 18px;
    color: #f5f5f5;
    font-family: 'Roboto', sans-serif;
    margin-top: 10px;
  }

  /* Legend container */
  .legend {
    margin: 20px 0;
    font-size: 16px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }

  /* Enkel legend-item (farvefelt + tekst) */
  .legend-item {
    display: flex;
    align-items: center;
  }

  /* Farvefelter i legend */
  .legend-color {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    border-radius: 3px;
  }

  /* Specifikke farver for tilgængelighed */
  .legend-green { background-color: #4CAF50; }
  .legend-yellow { background-color: #FFC107; }
  .legend-red { background-color: #F44336; }

  /* Tabel styling */
  table.schedule {
    border-collapse: collapse;
    width: 100%;
    color: #f5f5f5;
  }

  /* Tabelceller */
  table.schedule td {
    padding: 10px;
    border: 1px solid #ddd;
    vertical-align: top;
  }

  /* Kolonne med dag */
  table.schedule td.day-cell {
    font-weight: bold;
    width: 130px;
    background-color: transparent;
    text-align: center;
  }

  /* Styling af tid-knapper */
  button.time-box {
    display: inline-block;
    padding: 12px 18px;
    margin: 4px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 1.1em;
    color: white;
    min-width: 100px;
    font-family: inherit;
    text-align: center;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  /* Grøn box for god tilgængelighed */
  button.green-box { background-color: #4CAF50 !important; }
  button.green-box.clicked { background-color: #357a38 !important; }

  /* Gul box for mellem tilgængelighed */
  button.yellow-box { background-color: #FFC107 !important; }
  button.yellow-box.clicked { background-color: #b28905 !important; }

  /* Rød box for lav tilgængelighed */
  button.red-box { background-color: #F44336 !important; }
  button.red-box.clicked { background-color: #a32b23 !important; }

  /* Undertekst i tid-knapper */
  .time-box .subtext {
    display: block;
    font-weight: normal;
    font-size: 0.85em;
    margin-top: 6px;
  }
</style>

<main class="custom-page-billetter">

  <?php the_content(); // Vis sideindhold fra WordPress admin ?>

  <!-- CTA-knap og tilhørende info-tekst -->
  <div class="cta-wrapper">
    <button id="ctaButton" class="cta-button" disabled>Næste</button>
    <div class="cta-info-text">
      Vælg et tidspunkt herunder, derefter klik videre på "Næste" for at vælge pladser.
    </div>
  </div>

  <!-- Legend, der forklarer farvekodning -->
  <div class="legend">
    <div class="legend-item"><div class="legend-color legend-green"></div> 80-100% ledige pladser</div>
    <div class="legend-item"><div class="legend-color legend-yellow"></div> 20-80% ledige pladser</div>
    <div class="legend-item"><div class="legend-color legend-red"></div> 0-20% ledige pladser</div>
  </div>

  <!-- Tabel med ugeskema og tid-knapper -->
  <table class="schedule">
    <tbody>
      <?php
      date_default_timezone_set('Europe/Copenhagen'); // Sæt tidszone

      // Dage i ugen på dansk
      $days = [
        'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag', 'Søndag'
      ];

      // Loop gennem hver dag
      foreach ($days as $day) {
        echo '<tr>';
        echo '<td class="day-cell">' . esc_html($day) . '</td>';
        echo '<td>';

        // Generer 2 unikke tilfældige starttidspunkter mellem 12:00 og 22:00
        $showtimes = [];
        while (count($showtimes) < 2) {
          $hour = rand(12, 20); // Timer mellem 12 og 20
          $minute = rand(0, 1) ? '00' : '30'; // Minutter 00 eller 30
          $time = sprintf('%02d:%s', $hour, $minute);
          if (!in_array($time, $showtimes)) {
            $showtimes[] = $time;
          }
        }
        sort($showtimes); // Sorter tiderne i stigende rækkefølge

        // Loop gennem tiderne
        foreach ($showtimes as $time) {
          $seats_available = rand(0, 5); // Tilfældig tilgængelighed til demo
          $sal = rand(0, 1) ? 'Sal 1' : 'Sal 2'; // Tilfældig sal

          // Beregn sluttid (2 timer senere)
          $start = $time;
          $end = date('H:i', strtotime($start) + 2 * 3600);
          $time_range = "$start - $end";

          // Bestem farveklasse baseret på ledige pladser
          if ($seats_available >= 4) {
            $class = 'green-box';
          } elseif ($seats_available > 1) {
            $class = 'yellow-box';
          } else {
            $class = 'red-box';
          }

          // Udskriv knap med data attributter for dag og tid
          echo '<button 
                  class="time-box ' . esc_attr($class) . '" 
                  data-day="' . esc_attr($day) . '" 
                  data-time="' . esc_attr($start) . '" 
                >';
          echo esc_html($time_range);
          echo '<span class="subtext">2D, engelsk tale</span>';
          echo '<span class="subtext">' . esc_html($sal) . '</span>';
          echo '</button>';
        }

        echo '</td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>

</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const buttons = document.querySelectorAll("button.time-box");
  const ctaButton = document.getElementById("ctaButton");

  // Tilføj klik-event til hver tid-knap
  buttons.forEach(button => {
    button.addEventListener("click", function() {
      // Fjern 'clicked' klasse fra alle knapper
      buttons.forEach(btn => btn.classList.remove('clicked'));
      // Tilføj 'clicked' klasse til den valgte knap
      this.classList.add('clicked');
      // Aktiver CTA-knappen fordi en tid er valgt
      ctaButton.disabled = false;
    });
  });

  // Når CTA-knappen klikkes, og den er aktiveret, redirect til ny side
  ctaButton.addEventListener("click", function() {
    if (!ctaButton.disabled) {
      window.location.href = "https://laierdesign.dk/vaelg-pladser/";
    }
  });
});
</script>

<?php get_footer(); ?>