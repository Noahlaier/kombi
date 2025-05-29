<?php
/*
Template Name: Vælg Pladser Template
Template Post Type: page
*/
/* OpenAI. (2025) ChatGPT [large language model]. https://chatgpt.com/share/68370535-1e9c-800f-b1b1-1fd43e9a54d0 - lokaliseret d. 28/05 2025*/
get_header(); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@600&display=swap');

    /* Generel stil og baggrund */
    body {
        background-color: #373737;
        color: #f5f5f5;
        font-family: 'Roboto', sans-serif;
    }

    /* Container omkring hele indholdet */
    .custom-content {
        max-width: 720px;
        margin: 2rem auto;
        padding: 1.5rem 2rem;
        background-color: #171717;
        border: 2px solid white;
        border-radius: 15px;
        text-align: center;
        box-sizing: border-box;
    }

    h2 {
        margin-bottom: 30px;
    }

    /* Lærred-linje over sæderne */
    .screen-line {
        height: 2px;
        background-color: white;
        margin: 20px auto 30px auto;
        position: relative;
        max-width: calc((35px + 5px) * 13 + 10px);
    }

    .screen-line::before {
        content: "Lærred";
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #171717;
        padding: 0 10px;
        color: white;
        font-weight: bold;
    }

    /* Biograf-layout (sæder i rækker) */
    .cinema {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        max-width: calc((35px + 5px) * 13);
        margin: 0 auto;
    }

    .row {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .row.spacer {
        margin-bottom: 30px; /* Ekstra luft mellem række 2 og 3 */
    }

    /* Sæde-styling */
    .seat {
        width: 35px;
        height: 35px;
        background-color: #2a2a2a;
        border: 1px solid #a3a3a3;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        color: #f5f5f5;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
        user-select: none;
    }

    .seat.selected {
        background-color: #ff0032; /* Rød farve ved valg */
    }

    /* Handicap-sæder */
    .seat.handicap {
        background-color: #444;
        border: 2px dashed #fff;
    }

    .seat.handicap.selected {
        background-color: #ff0032;
    }

    .seat.handicap::after {
        content: "♿";
        font-size: 12px;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
    }

    /* Knappen til at bestille billetter */
    .order-button {
        margin: 40px auto 0 auto;
        background-color: #ff0032;
        color: white;
        border: none;
        padding: 14px 50px;
        font-size: 19px;
        font-weight: 600;
        font-family: 'Roboto', sans-serif;
        border-radius: 9999px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        display: block;
        text-decoration: none;
    }

    .order-button:hover {
        color: #f5f5f5;
        background-color: #e60029;
    }

    /* Deaktiveret knap */
    .order-button.disabled-button {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Formular til billetvalg */
    .betaling-form {
        background-color: #171717;
        padding: 20px;
        max-width: 400px;
        margin: 40px auto 0 auto;
        border-radius: 50px; /* meget rund */
        border: 1px solid #f5f5f5;
        color: #f5f5f5;
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 19px;
        font-weight: 700; /* bold */
        text-align: left;
    }
    .betaling-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #f5f5f5;
    }
    .betaling-form select,
    .betaling-form input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 50px; /* meget rund */
        border: 1px solid #f5f5f5;
        background-color: #757575; /* opdateret til ønsket grå */
        color: #f5f5f5;
        font-size: 19px;
        font-weight: 700;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .betaling-form input[readonly] {
        cursor: default;
    }
    .betaling-form button {
        background-color: #ff0032;
        color: #f5f5f5;
        padding: 12px 25px;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 19px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .betaling-form button:hover {
        background-color: #cc0029;
    }

    /* Gør layoutet mobilvenligt */
    @media screen and (max-width: 600px) {
        .seat {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .order-button {
            padding: 12px 40px;
            font-size: 17px;
        }

        .custom-content {
            max-width: 90%;
            padding: 1rem;
        }

        .betaling-form {
            max-width: 100%;
            padding: 15px;
        }
    }
</style>

<!-- HTML-indhold starter her -->
<div class="custom-content">
    <h2>Vælg dine pladser</h2>
    <div class="screen-line"></div>

    <div class="cinema">
        <?php
        // Generer 5 rækker af sæder
        for ($row = 1; $row <= 5; $row++) {
            // Række 5 har 13 pladser, resten har 11
            $seatsInRow = ($row === 5) ? 13 : 11;
            // Ekstra afstand efter række 2
            $rowClass = ($row === 3) ? 'row spacer' : 'row';
            echo "<div class='$rowClass'>";
            for ($seat = 1; $seat <= $seatsInRow; $seat++) {
                // Gør plads 10 og 11 i række 3 til handicap
                $isHandicap = ($row === 3 && ($seat === 10 || $seat === 11));
                $classes = 'seat' . ($isHandicap ? ' handicap' : '');
                echo "<div class='$classes'>{$seat}</div>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <!-- Formular til valg af antal billetter og pris -->
    <form class="betaling-form" id="billetForm" method="POST" onsubmit="return redirectToSuccessPage(event);">
        <label for="antalBilletter">Antal billetter valgt:</label>
        <select id="antalBilletter" name="antalBilletter" disabled>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>

        <label for="totalPris">Total pris (kr.):</label>
        <input type="text" id="totalPris" name="totalPris" value="0" readonly />

        <button type="submit" id="betalKnap" disabled>Betal nu</button>
    </form>
</div>

<!-- JavaScript til interaktion -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const seats = document.querySelectorAll('.seat:not(.handicap)');
        const antalBilletterSelect = document.getElementById('antalBilletter');
        const totalPrisInput = document.getElementById('totalPris');
        const betalKnap = document.getElementById('betalKnap');
        const billetPris = 95;
        const maxBilletter = 10;

        // Opdater knap og pris baseret på antal valgte sæder
        function updateState() {
            const selectedSeats = [...seats].filter(seat => seat.classList.contains('selected'));
            const antalValgte = selectedSeats.length;

            // Opdater billetantal (værdien og den valgte option)
            if (antalValgte === 0) {
                antalBilletterSelect.value = 0;
                totalPrisInput.value = 0;
                betalKnap.disabled = true;
            } else {
                antalBilletterSelect.value = antalValgte;
                totalPrisInput.value = antalValgte * billetPris;
                betalKnap.disabled = false;
            }
        }

        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                // Hvis sædet ikke er valgt og max antal nået, ignorer klik
                if (!seat.classList.contains('selected')) {
                    const currentSelected = [...seats].filter(s => s.classList.contains('selected')).length;
                    if (currentSelected >= maxBilletter) {
                        alert("Du kan maks vælge 10 billetter.");
                        return;
                    }
                }

                // Toggle valget på sædet
                seat.classList.toggle('selected');
                updateState();
            });
        });

        // Ved indsendelse af formular, redirect til takkeside
        function redirectToSuccessPage(event) {
            event.preventDefault();
            // Her kan evt. backend håndtering tilføjes senere

            window.location.href = "https://laierdesign.dk/kob-af-billet-gennemfort/";
            return false;
        }

        document.getElementById('billetForm').addEventListener('submit', redirectToSuccessPage);

        // Start med opdateret tilstand (ingen valgt)
        updateState();
    });
</script>

<?php get_footer(); ?>