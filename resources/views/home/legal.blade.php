@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-gray-dark-v3 g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">Impressum</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="container g-py-50">
        <div class="row">
            <div class="col-lg-6">
                <h1>Impressum</h1>
                <p>Angaben gemäß § 5 TMG</p>
                <p>Thomas Wolter <br>
                    Ulrich-von-Hutten Straße 45<br>
                    16540 Hohen Neuendorf <br>
                </p>
                <p><strong>Vertreten durch: </strong><br>
                    Thomas Wolter<br>
                </p>
                <p><strong>Kontakt:</strong> <br>
                    Telefon: 3303-5089908<br>
                    E-Mail: <a href='mailto:thwolter@gmail.com'>thwolter@gmail.com</a></br></p>
                <p><strong>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:</strong><br>
                    Thomas Wolter <br>
                    Ulrich-von-Hutten Straße 45<br>
                    16540 Hohen Neuendorf <br>
                </p>
            </div>
            <div class="col-lg-6">
                <div class='impressum'>

                    <p>
                        <strong>Haftungsausschluss: </strong><br><br>

                        <strong>Haftung für Inhalte</strong><br><br>
                        Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit,
                        Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als
                        Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den
                        allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch
                        nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach
                        Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur
                        Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben
                        hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis
                        einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden
                        Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.<br><br>

                        <strong>Haftung für Links</strong><br><br>
                        Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss
                        haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die
                        Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten
                        verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche
                        Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht
                        erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete
                        Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen
                        werden wir derartige Links umgehend entfernen.<br><br>
                        <strong>Urheberrecht</strong><br><br>
                        Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem
                        deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der
                        Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des
                        jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten,
                        nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber
                        erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter
                        als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam
                        werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen
                        werden wir derartige Inhalte umgehend entfernen.<br><br>
                </div>

            </div>
        </div>
    </section>

    <div id="stickyblock-end"></div>

@endsection


@section('link.header')

@endsection


@section('script.footer')

    <!-- JS Unify -->
    <script src="{{ asset('assets/js/components/hs.sticky-block.js') }}"></script>


    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {

            // initialization of sticky blocks
            $.HSCore.components.HSStickyBlock.init('.js-sticky-block');

        });

    </script>

@endsection

