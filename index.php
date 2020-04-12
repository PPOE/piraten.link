<!DOCTYPE html>
<html lang="de-AT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Piraten-Link Shorter</title>
    <link rel="stylesheet" href="frontend/css/main.min.css">
</head>
<body>
    <main class="content">
        <div class="display-table">
            <div class="display-table-cell">
                <div class="form-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-container">
                                    <div class="image-above">
                                        <img src="./frontend/images/PIRATENsignet.svg" alt="Piraten Signet">
                                    </div> 
                                    <div class="description text-left">
                                        <h1 class="text-center"> Piraten.Link URL Shortener</h1>
                                        <p>Wenn Du Dir lange Links auch so schlecht merkst wie wir, oder aber Flexibilität brauchst, dann kannst Du Dir hier einfach eine Short URL anlegen, die mit <a href="https://piraten.link/">piraten.link/</a> beginnt. Solltest Du einen bestehenden Link ändern müssen, dann wende Dich mit Deinem Anliegen an <a href="mailto:agtechnik@piratenpartei.at">agtechnik[AT]piratenpartei.at</a>.</p>
                                    </div>
                                    <div class="spacer-small"></div>
                                    <div class="form">
                                        <form method="post" action="" class="row">
                                            <div class="form-group col-lg-6">
                                                <input type="url" class="text form-control" name="url" placeholder="URL zum Kürzen einfügen" required/>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="text" class="text form-control" name="keyword" placeholder="kurze URL" />
                                            </div>
                                            <div class="spacer-xsmall"></div>
                                            <div class="form-group col-12">
                                                <input type="submit" class="button submit-button" value="Kürzen" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="spacer-xsmall"></div>
                                    <div class="description text-center">
                                        <p class="disclaimer"><strong>Disclaimer</strong>: Unser Dienst leitet ausschließlich auf bestehende Inhalte weiter. Wir übernehmen daher keinerlei Verantwortung für die verlinkten Inhalte.</p>
                                    </div>
                                </div>
                                <div class="form-footer">
                                    <nav>
                                        <ul>
                                            <li><a href="https://wiki.piratenpartei.at/wiki/Piratenwiki:Impressum">Impressum</a></li>
                                            <li><a href="https://www.piratenpartei.at">Piratenpartei Österreichs</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="frontend/javascript/external/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <?php 
        // Start YOURLS engine
        require_once( dirname(__FILE__).'/includes/load-yourls.php' );

        // Change this to match the URL of your public interface. Something like: http://your-own-domain-here.com/index.php
        $page = YOURLS_SITE . '/index.php' ;
        $site = YOURLS_SITE;
        if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {
            // Get parameters -- they will all be sanitized in yourls_add_new_link()
            $url     = $_REQUEST['url'];
            $keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
            $title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
            $text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;
                
            // Create short URL, receive array $return with various information
            $return  = yourls_add_new_link( $url, $keyword, $title );
            
            $shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
            $message  = isset( $return['message'] ) ? $return['message'] : '';
            $title    = isset( $return['title'] ) ? $return['title'] : '';
            $status   = isset( $return['status'] ) ? $return['status'] : '';
                    
            // Stop here if bookmarklet with a JSON callback function ("instant" bookmarklets)
            if( isset( $_GET['jsonp'] ) && $_GET['jsonp'] == 'yourls' ) {
                $short = $return['shorturl'] ? $return['shorturl'] : '';
                $message = "Short URL (Ctrl+C to copy)";
                header('Content-type: application/json');
                echo yourls_apply_filter( 'bookmarklet_jsonp', "yourls_callback({'short_url':'$short','message':'$message'});" );
                
                die();
            }
        }
        // Part to be executed if FORM has been submitted
        if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {
            if( $status == 'success' ) {
                echo "<script>Swal.fire('Link erfolgreich gekürzt!','Dein Link ". $url ." wurde erfolgreich gekürzt und ist nun unter ". $shorturl ." erreichbar.','success');</script>";
            }
            else {
                echo "<script>Swal.fire('Fehler','Leider ist ein Fehler aufgetreten. Bitte kontrolliere deine Eingabe und probiere es erneut.<br>Fehler: ". $message ."','error');</script>";
            }
        }
    ?>
</body>
</html>