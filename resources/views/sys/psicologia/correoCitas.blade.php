<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Use the latest (edge) version of IE rendering engine -->
    <title>EmailTemplate-Fluid</title>
    <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Reset -->
    <style type="text/css">
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap');
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Montserrat', sans-serif;
        }



        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Forces Outlook.com to display emails full width. */
        .ExternalClass {
            width: 100%;
        }

        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Overrides styles added when Yahoo's auto-senses a link. */
        .yshortcuts a {
            border-bottom: none !important;
        }

        /* What it does: Another work-around for iOS meddling in triggered links. */
        a[x-apple-data-detectors] {
            color: inherit !important;
        }

    </style>

    <!-- Progressive Enhancements -->
    <style type="text/css">
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }

        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

    </style>
</head>

<body width="100%" height="100%" bgcolor="FAFAFA" style="margin: 0;" yahoo="yahoo">
    <table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" bgcolor="FAFAFA"
        style="border-collapse:collapse;">
        <tr>
            <td>
                <center style="width: 100%;">

                    <!-- Visually Hidden Preheader Text : BEGIN -->
                    <div
                        style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;">
                        </div>
                    <!-- Visually Hidden Preheader Text : END -->

                    <div style="max-width: 600px;">

                        <!-- Email Header : BEGIN -->
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
                            style="max-width: 600px;">
                            <tr>
                                <td style="padding: 20px 0; text-align: center"><img
                                        src="https://portal.unag.edu.hn/wp-content/uploads/2020/10/UNAG_Oficial_COLOR.png"
                                        width="200" height="65" alt="alt_text" border="0"></td>
                            </tr>
                        </table>
                        <!-- Email Header : END -->

                        <!-- Email Body : BEGIN -->
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%"
                            style="max-width: 600px;">

                            <!-- Hero Image, Flush : BEGIN -->
                           <!-- <tr>
                                <td class="full-width-image" align="center"><img
                                        src="https://portal.unag.edu.hn/wp-content/uploads/2022/05/SLIDE_EMAIL.jpg"
                                        width="600" alt="alt_text" border="0"
                                        style="width: 100%; max-width: 600px; height: auto;"></td>
                            </tr>
                             Hero Image, Flush : END -->

                            <!-- 1 Column Text : BEGIN -->
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td
                                                style="padding: 40px; font-size: 15px; mso-height-rule: exactly; line-height: 19px; color: #555555; text-align: justify">                                                 
                                                
                                                ¡Saludos!, por este medio se le comunica que el estuidnate <b>{{$nombre_completo_estudiante}}</b> fue referido, para mas detalles revisar el ERP.
                                               
                                                                                                                                               
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <!-- Button : Begin -->
                                                <table cellspacing="0" cellpadding="0" border="0" align="center"
                                                    style="margin: auto; background-color:#f5f5f5; width:100%">
                                                    <tr>
                                                        <td style="border-radius: 3px; text-align:center; ">
                                                            <br> 
                                                            
                                                                Fecha de la cita: <b style="color:#08a42a">{{$fecha_cita}}</b><br>
                                                                Observaciones: <b style="color:#08a42a">{{$observaciones}}</b><br>
                                                                
                                                             
                                            
                                                            
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <table cellspacing="0" cellpadding="0" border="0" align="center"
                                                    style="margin: auto;">
                                                    <tr style="">                                                                                                                                                                       
                                                    </tr>                                                    
                                                </table>                                                                                             
                                                <!-- Button : END -->
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- 1 Column Text : BEGIN -->

                            <!-- Two Even Columns : BEGIN -->
                            <tr>
                                <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%">                                                                                                  
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%"
                                        style="max-width:560px;">
                                        <tr>                                                                                       
                                        </tr>
                                    </table>
                                </td>
                            </tr>
<!--                            <tr>
                                <td class="full-width-image" align="center"><img
                                        src="https://portal.unag.edu.hn/wp-content/uploads/2022/05/SLIDE_EMAIL_2.jpg"
                                        width="600" alt="alt_text" border="0"
                                        style="width: 100%; max-width: 600px; height: auto;"></td>
                            </tr>-->
                        </table>
                        <!-- Email Footer  -->
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
                            style="max-width: 680px;">
                            <tr>
                                <td
                                    style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">                                                                        
                                    <a>Para más información: info@unag.edu.hn</a>
                                    <br>
                                    <br>
                                    <a>Universidad Nacional de Agricultura</a><br>
                                    <span class="mobile-link--footer">&copy; Todos los derechos Reservados</span>
                                    <br>
                                    <br>                                   
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
            </td>
        </tr>
    </table>
</body>

</html>
