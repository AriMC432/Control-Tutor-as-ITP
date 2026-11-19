 <!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>

        @yield('title', 'Control de Tutorías ITP')

    </title>

    <link

        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"

        rel="stylesheet"

    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <style>
        :root {

            --brand-blue: #174c9b;
            --brand-blue-dark: #0b2f68;
            --brand-blue-light: #2f8fff;
            --brand-blue-glow: #55adff;
            --body-bg: #f4f8fd;
            --card-border: #dce6f2;
            --footer-bg: #0c2d61;
            --footer-text: #e9eef7;
            --footer-accent:
                linear-gradient(
                    90deg,
                    #08bde9,
                    #22c55e,
                    #a855f7
                );
        }
        html,
        body {
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family:
                'Segoe UI',
                Tahoma,
                Geneva,
                Verdana,
                sans-serif;
            background:
                linear-gradient(
                    180deg,
                    #f8fbff 0%,
                    #f1f5fa 100%
                );
            color: #17345f;
        }

        .top-band {
            width: 100%;
            min-height: 86px;
            background:
                linear-gradient(
                    135deg,
                    #1d57a7 0%,
                    #16478e 45%,
                    #0b2f68 100%
                );

            color: white;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 2000;
            box-shadow:
                0 7px 24px rgba(7, 35, 80, .22);
            overflow: visible !important;
        }



        .top-band-inner {



            width: 100%;



            padding:

                0 3cm;



            display: flex;



            align-items: center;



            justify-content: space-between;



            gap: 25px;



            position: relative;

            z-index: 2;

        }



        .brand-area {



            display: flex;



            align-items: center;



            min-width: 0;

        }





        .brand-link {



            display: flex;



            align-items: center;



            text-decoration: none;



            color: white;



            transition:

                transform .25s ease;

        }





        .brand-link:hover {



            color: white;



            transform:

                translateY(-1px);

        }



        .top-band img {



            width: auto;



            height: 58px;



            object-fit: contain;



            margin-right: 20px;



            flex-shrink: 0;



            filter:

                drop-shadow(

                    0 3px 5px rgba(0,0,0,.20)

                );

        }



        .brand-separator {



            width: 1px;



            height: 48px;



            background:

                rgba(255,255,255,.42);



            margin-right: 20px;



            flex-shrink: 0;

        }



        .top-title {



            color: #ffffff;



            font-size: 1.48rem;



            font-weight: 750;



            line-height: 1.2;



            white-space: nowrap;



            letter-spacing: -.2px;

        }



        .header-login {



            display: inline-flex;



            align-items: center;



            justify-content: center;



            gap: 9px;



            min-width: 158px;



            padding:

                11px 22px;



            border-radius: 50px;



            color: white !important;



            text-decoration: none;



            font-size: .94rem;



            font-weight: 700;



            background:

                rgba(255,255,255,.10);



            border:

                1px solid rgba(255,255,255,.65);



            box-shadow:

                0 5px 18px rgba(0,0,0,.12);



            backdrop-filter:

                blur(10px);



            transition:

                all .25s ease;

        }





        .header-login i {



            font-size: 1.05rem;

        }





        .header-login:hover {



            background: #ffffff;



            color:

                #174c9b !important;



            border-color:

                #ffffff;



            transform:

                translateY(-2px);



            box-shadow:

                0 8px 24px rgba(0,0,0,.22);

        }



        .header-user {



            display: flex;



            align-items: center;



            gap: 12px;



            color: white;



            flex-shrink: 0;

        }



        .header-user-avatar {



            width: 48px;



            height: 48px;



            border-radius: 50%;



            display: flex;



            align-items: center;



            justify-content: center;



            background: white;



            color:

                #17529d;



            font-size: 1.35rem;



            border:

                2px solid rgba(255,255,255,.85);



            box-shadow:

                0 3px 10px rgba(0,0,0,.18);

        }



.header-user-photo {



    width: 100%;

    height: 100%;



    border-radius: 50%;



    object-fit: cover;



    display: block;



}



.header-user-fallback {



    width: 100%;

    height: 100%;



    align-items: center;

    justify-content: center;



}



        .header-user-info {



            display: flex;



            flex-direction: column;



            line-height: 1.1;

        }





        .header-user-name {



            font-size: .98rem;



            font-weight: 700;



            color: white;

        }





        .header-user-role {



            font-size: .78rem;



            font-weight: 600;



            color:

                rgba(255,255,255,.82);



            margin-top: 3px;

        }



        .header-user-toggle {



            color: white !important;



            text-decoration: none;



            display: flex;



            align-items: center;



            gap: 8px;



            padding:

                6px 4px;



            border: none;



            background: transparent;

        }





        .header-user-toggle:hover {



            color: white !important;

        }



        .header-user-menu {



            min-width: 205px;



            margin-top: 10px !important;



            border:

                1px solid #d8e3f1;



            border-radius: 13px;



            padding: 8px;



            box-shadow:

                0 14px 35px rgba(15,50,100,.18);

        }





        .header-user-menu .dropdown-item {



            border-radius: 9px;



            padding:

                10px 12px;



            font-weight: 600;

        }





        .header-user-menu .dropdown-item:hover {



            background:

                #edf5ff;



            color:

                #1458ad;

        }





        .header-user-menu

        .dropdown-item.logout-item {



            color:

                #dc3545;

        }





        .header-user-menu

        .dropdown-item.logout-item:hover {



            background:

                #fff0f1;



            color:

                #c82333;

        }



        main.app-main {



            flex: 1;



            width: 100%;



            padding:

                28px 3cm 55px;



            box-sizing: border-box;

        }





        .app-content {



            width: 100%;



            max-width: none;



            margin: 0 auto;

        }



        .subnav {



            width:

                calc(100% - 6cm);



            margin-left: 3cm;



            margin-right: 3cm;



            margin-top: 18px;



            background:

                linear-gradient(

                    135deg,

                    #103f87 0%,

                    #082d67 100%

                );



            border:

                1px solid rgba(80,160,255,.45);



            border-radius: 16px;



            position: relative;



            z-index: 1500;



            box-shadow:

                0 9px 24px rgba(12,55,115,.20);

        }





        .subnav .container {



            width: 100%;



            max-width: none;



            padding:

                7px 10px;

        }





        .subnav .nav {
            width: 100%;
            margin: 0;
            padding: 0 0 0 33px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }





        .subnav .nav-item {



            margin: 0;



            flex: 0 0 auto;

        }





        .subnav .nav-link {



            min-width: 150px;



            height: 48px;



            padding:

                0 20px;



            display: flex;



            align-items: center;



            justify-content: center;



            gap: 9px;



            border-radius: 11px;



            border:

                1px solid rgba(91,164,244,.55);



            background:

                rgba(27,87,165,.28);



            color: white;



            font-size: .96rem;



            font-weight: 700;



            text-decoration: none;



            white-space: nowrap;



            transition:

                *background* .20s ease,

                border-color .20s ease,

                box-shadow .20s ease,

                transform .20s ease;

        }





        .subnav .nav-icon {



            font-size: 1rem;



            line-height: 1;

        }





        .subnav .nav-link:hover {



            color: white;



            background:

                linear-gradient(

                    180deg,

                    #3194ff 0%,

                    #176bd7 100%

                );



            border-color:

                #7bc7ff;



            box-shadow:

                0 0 6px rgba(55,160,255,1),

                0 0 14px rgba(55,160,255,.90),

                0 0 26px rgba(55,160,255,.55),

                inset 0 1px 0 rgba(255,255,255,.45);



            transform:

                translateY(-1px);

        }





        .subnav .nav-link.active {



            color: white;



            background:

                linear-gradient(

                    180deg,

                    #3194ff 0%,

                    #176bd7 100%

                );



            border-color:

                #7bc7ff;



            box-shadow:

                0 0 7px rgba(55,160,255,1),

                0 0 17px rgba(55,160,255,.90),

                0 0 30px rgba(55,160,255,.55),

                inset 0 1px 0 rgba(255,255,255,.50);

        }



        .card {



            border:

                1px solid var(--card-border);



            border-radius: 16px;



            box-shadow:

                0 5px 18px rgba(30,70,120,.08);

        }





        .dashboard-card,

        .panel-card {



            border-radius: 16px;



            border:

                1px solid #dce6f2;



            background: white;



            box-shadow:

                0 5px 18px rgba(30,70,120,.08);

        }



        .foto-container {



            position: relative;



            width: fit-content;



            margin: 0 auto;

        }





        .profile-img {



            width: 160px;



            height: 160px;



            border-radius: 50%;



            object-fit: cover;



            border:

                3px solid white;



            box-shadow:

                0 3px 12px rgba(0,0,0,.12);



            display: block;

        }





        .btn-edit-foto {



            position: absolute;



            bottom: 10px;



            right: 10px;



            width: 40px;



            height: 40px;



            border-radius: 50%;



            background:

                linear-gradient(

                    135deg,

                    #2688f5,

                    #145dc0

                );



            color: white;



            border:

                2px solid white;



            display: flex;



            align-items: center;



            justify-content: center;



            text-decoration: none;



            transition:

                all .2s ease;



            box-shadow:

                0 3px 8px rgba(0,0,0,.20);



            z-index: 10;

        }





        .btn-edit-foto:hover {



            background:

                linear-gradient(

                    135deg,

                    #3a9cff,

                    #176bd7

                );



            transform:

                scale(1.08);



            color: white;



            box-shadow:

                0 0 12px rgba(55,160,255,.65);

        }



        footer {



            background:

                var(--footer-bg);



            color:

                var(--footer-text);



            margin-top: auto;

        }





        .footer-accent {



            height: 5px;



            background:

                var(--footer-accent);

        }





        .footer-title {



            text-transform: uppercase;



            font-weight: 700;



            margin-bottom: .75rem;



            color: white;



            letter-spacing: .2px;

        }





        .footer-link {



            color:

                #d7e3ff;



            text-decoration: underline;



            text-underline-offset: 2px;

        }





        .footer-link:hover {



            color: white;

        }





        .footer-btn {



            background:

                rgba(255,255,255,.08);



            color: white;



            border:

                1px solid rgba(255,255,255,.18);



            border-radius:

                .75rem;



            padding:

                .6rem .9rem;



            transition:

                all .2s ease;

        }





        .footer-btn:hover {



            background:

                rgba(255,255,255,.17);



            transform:

                translateY(-1px);



            color: white;

        }



        .footer-container{

    width:min(1250px,calc(100% - 80px));

    margin:auto;

    padding:28px 0;

}





        .map-wrapper{

    height:235px;

    border:1px solid rgba(255,255,255,.18);

    border-radius:18px !important;

    overflow:hidden;

    background:#fff;

    box-shadow:0 12px 28px rgba(0,0,0,.22);

}

.map-wrapper .ratio{height:100%;}

.map-wrapper iframe{

    width:100%;

    height:100%;

    border:0;

    display:block;

}





        .footer-bottom {



            background:

                linear-gradient(

                    0deg,

                    rgba(255,255,255,.04),

                    rgba(255,255,255,0)

                );



            border-top:

                1px solid rgba(255,255,255,.12);

        }



        @media (max-width: 1200px) {



            .top-band-inner {



                padding:

                    0 30px;

            }





            main.app-main {



                padding-left: 30px;



                padding-right: 30px;

            }





            .subnav {



                width:

                    calc(100% - 60px);



                margin-left: 30px;



                margin-right: 30px;

            }

        }





        @media (max-width: 768px) {



            .top-band {



                min-height: 74px;

            }





            .top-band-inner {



                padding:

                    0 16px;

            }





            .top-band img {



                height: 43px;



                margin-right: 10px;

            }





            .brand-separator {



                margin-right: 10px;



                height: 35px;

            }





            .top-title {



                font-size:

                    1rem;

            }





            .header-login {



                min-width: auto;



                padding:

                    9px 13px;

            }





            .header-login span {



                display: none;

            }





            .header-login i {



                font-size:

                    1.15rem;

            }





            .header-user-info {



                display: none;

            }





            .header-user-avatar {



                width: 42px;



                height: 42px;

            }





            main.app-main {



                padding:

                    18px 16px 35px;

            }





            .subnav {



                width:

                    calc(100% - 32px);



                margin-left: 16px;



                margin-right: 16px;



                margin-top: 12px;

            }





            .subnav .nav {



                overflow-x: auto;



                padding-bottom: 2px;

            }





            .subnav .nav-link {



                min-width: 130px;

            }

        }





        @media (max-width: 480px) {



            .top-title {



                font-size:

                    .88rem;

            }





            .top-band img {



                height: 38px;

            }





            .brand-separator {



                height: 30px;

            }

        }



    

/* Estilos de la página de inicio y del pie institucional compacto */


/* =========================================================

   PÁGINA DE INICIO

========================================================= */


.inicio-principal {

    width: 100%;

    max-width: 1450px;

    margin: 0 auto;

    padding: 16px 32px 22px;

}


/* =========================================================

   BIENVENIDA

========================================================= */


.presentacion {

    text-align: center;

    margin: 0 auto 18px;

}


.presentacion .etiqueta {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 6px 15px;

    margin-bottom: 7px;

    border-radius: 50px;

    background: #eaf3ff;

    border: 1px solid #cfe3ff;

    color: #1769c2;

    font-size: .78rem;

    font-weight: 700;

    box-shadow: 0 4px 12px rgba(23,105,194,.08);

}


.presentacion h1 {

    margin: 0;

    color: #123f7a;

    font-size: clamp(1.8rem, 3.3vw, 2.65rem);

    font-weight: 800;

    letter-spacing: -.7px;

}


.presentacion p {

    max-width: 800px;

    margin: 6px auto 0;

    color: #66788e;

    font-size: .94rem;

    line-height: 1.45;

}


/* =========================================================

   DISTRIBUCIÓN PRINCIPAL

   CARRUSEL IZQUIERDA + TARJETAS DERECHA

========================================================= */


.inicio-contenido {

    display: grid;

    grid-template-columns: minmax(0, 1.65fr) minmax(280px, 1fr);

    gap: 22px;

    align-items: stretch;

}


/* =========================================================

   CARRUSEL

========================================================= */


.carrusel-contenedor {

    position: relative;

    min-width: 0;

    height: 100%;

    min-height: 355px;

    padding: 5px;

    border-radius: 21px;

    background: linear-gradient(135deg, #0d438b, #2588e8, #123f7a);

    box-shadow: 0 12px 28px rgba(12,55,110,.17);

}


.carrusel {

    width: 100%;

    height: 100%;

    min-height: 345px;

    overflow: hidden;

    border-radius: 17px;

    background: #0b3775;

}


.carrusel .carousel-inner,

.carrusel .carousel-item {

    height: 100%;

    min-height: 345px;

}


.carrusel img {

    display: block;

    width: 100%;

    height: 355px;

    object-fit: cover;

    object-position: center;

    transition: transform 7s ease;

}


.carrusel .carousel-item.active img {

    transform: scale(1.025);

}


/* Oscurecimiento para mejorar la lectura */

.carrusel .carousel-item::after {

    content: "";

    position: absolute;

    inset: 0;

    z-index: 1;

    background: linear-gradient(

        to top,

        rgba(5,27,62,.88) 0%,

        rgba(5,27,62,.35) 48%,

        rgba(5,27,62,.04) 100%

    );

    pointer-events: none;

}


/* Texto del carrusel */

.carrusel-texto {

    position: absolute;

    z-index: 3;

    left: 35px;

    right: 35px;

    bottom: 35px;

    color: #ffffff;

}


.carrusel-texto .mini-titulo {

    display: inline-block;

    padding: 5px 12px;

    margin-bottom: 8px;

    border-radius: 50px;

    background: rgba(31,125,235,.94);

    border: 1px solid rgba(255,255,255,.35);

    font-size: .68rem;

    font-weight: 700;

    letter-spacing: .7px;

    text-transform: uppercase;

}


.carrusel-texto h2 {

    margin: 0 0 6px;

    color: #ffffff;

    font-size: clamp(1.45rem, 2.5vw, 2.15rem);

    font-weight: 800;

    line-height: 1.15;

    text-shadow: 0 3px 12px rgba(0,0,0,.35);

}


.carrusel-texto p {

    max-width: 620px;

    margin: 0;

    color: rgba(255,255,255,.94);

    font-size: .88rem;

    line-height: 1.45;

}


/* Flechas */

.carrusel .carousel-control-prev,

.carrusel .carousel-control-next {

    z-index: 5;

    top: 50%;

    width: 42px;

    height: 42px;

    margin: 0 12px;

    border-radius: 50%;

    background: rgba(8,45,94,.65);

    border: 1px solid rgba(255,255,255,.45);

    opacity: 1;

    transform: translateY(-50%);

    transition: .2s ease;

}


.carrusel .carousel-control-prev:hover,

.carrusel .carousel-control-next:hover {

    background: #1976ed;

    box-shadow: 0 0 15px rgba(60,170,255,.65);

}


/* Indicadores */

.carrusel .carousel-indicators {

    z-index: 5;

    margin-bottom: 12px;

}


.carrusel .carousel-indicators button {

    width: 20px;

    height: 4px;

    border: 0;

    border-radius: 20px;

    margin: 0 3px;

    opacity: .55;

}


.carrusel .carousel-indicators button.active {

    width: 38px;

    opacity: 1;

}


/* =========================================================

   TARJETAS DERECHAS

========================================================= */


.panel-tarjetas {

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    gap: 12px;

    min-width: 0;

}


.tarjeta-inicio {

    flex: 1;

    display: flex;

    align-items: center;

    gap: 15px;

    min-height: 0;

    padding: 16px 18px;

    background: #ffffff;

    border-radius: 15px;

    border: 1px solid #dce7f4;

    box-shadow: 0 5px 17px rgba(21,62,108,.06);

    transition: .22s ease;

}


.tarjeta-inicio:hover {

    transform: translateX(3px);

    border-color: #b8d7f7;

    box-shadow: 0 9px 22px rgba(21,62,108,.11);

}


.icono-tarjeta {

    width: 45px;

    height: 45px;

    flex: 0 0 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 13px;

    color: #1876df;

    background: #eaf3ff;

    border: 1px solid #d1e5ff;

    font-size: 1.2rem;

}


.tarjeta-texto {

    min-width: 0;

}


.tarjeta-inicio h3 {

    color: #173f75;

    font-size: .98rem;

    font-weight: 800;

    margin: 0 0 5px;

}


.tarjeta-inicio p {

    color: #718096;

    font-size: .81rem;

    line-height: 1.4;

    margin: 0;

}


/* =========================================================

   FRASE INSTITUCIONAL

========================================================= */


.frase {

    text-align: center;

    margin: 17px 0 0;

}


.frase h2 {

    margin: 0;

    color: #123f7a;

    font-size: 1.28rem;

    font-weight: 800;

}


.frase p {

    margin: 4px 0 0;

    color: #718096;

    font-size: .84rem;

}


/* =========================================================

   PIE DE PÁGINA COMPACTO

========================================================= */


.footer-itp {

    position: relative;

    z-index: 20;

    width: 100%;

    margin-top: 15px;

    padding: 13px 5% 9px;

    background: #0d2f63;

    color: #ffffff;

    border-top: 3px solid #20b8c5;

    font-family: inherit;

}


.footer-contenido {

    width: 100%;

    max-width: 1250px;

    margin: 0 auto;

    display: grid;

    grid-template-columns: 1fr 1fr 1fr;

    gap: 28px;

    align-items: center;

}


.footer-columna {

    min-width: 0;

    position: relative;

}


.footer-titulo {

    margin: 0 0 7px;

    color: #ffffff;

    font-size: .78rem;

    font-weight: 800;

    letter-spacing: .5px;

    text-transform: uppercase;

}


/* Elementos que abren ventanas */

.footer-interactivo {

    position: relative;

    display: inline-block;

}


.footer-disparador {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 6px 10px;

    border: 1px solid rgba(255,255,255,.22);

    border-radius: 8px;

    background: rgba(255,255,255,.07);

    color: #ffffff;

    font-size: .81rem;

    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;

}


.footer-disparador:hover,

.footer-disparador:focus {

    background: #1769c2;

    border-color: #75bdff;

    color: #ffffff;

    outline: none;

}


.footer-disparador i {

    color: #8bd5ff;

}


/* Ventanas flotantes */

.footer-ventana {

    position: absolute;

    z-index: 100;

    left: 0;

    bottom: calc(100% + 12px);

    width: 260px;

    padding: 13px;

    border: 1px solid #dce8f5;

    border-radius: 12px;

    background: #ffffff;

    color: #263c57;

    box-shadow: 0 12px 30px rgba(0,0,0,.23);

    opacity: 0;

    visibility: hidden;

    transform: translateY(7px);

    transition: .2s ease;

    pointer-events: none;

}


.footer-interactivo:hover .footer-ventana,

.footer-interactivo:focus-within .footer-ventana {

    opacity: 1;

    visibility: visible;

    transform: translateY(0);

    pointer-events: auto;

}


.footer-ventana::after {

    content: "";

    position: absolute;

    left: 20px;

    bottom: -7px;

    width: 13px;

    height: 13px;

    background: #ffffff;

    border-right: 1px solid #dce8f5;

    border-bottom: 1px solid #dce8f5;

    transform: rotate(45deg);

}


.footer-ventana strong {

    display: block;

    margin-bottom: 6px;

    color: #123f7a;

    font-size: .85rem;

}


.footer-ventana p {

    margin: 0;

    color: #586b82;

    font-size: .78rem;

    line-height: 1.5;

}


.footer-ventana a {

    color: #1769c2;

    text-decoration: none;

}


.footer-ventana a:hover {

    text-decoration: underline;

}


/* Mapa emergente */

.footer-mapa-ventana {

    width: 300px;

    padding: 9px;

}


.footer-mapa-ventana strong {

    padding: 3px 5px 8px;

}


.footer-mapa-ventana iframe {

    display: block;

    width: 100%;

    height: 165px;

    border: 0;

    border-radius: 9px;

}


.footer-mapa-enlace {

    display: inline-block;

    margin: 7px 5px 2px;

    font-size: .77rem;

    font-weight: 700;

}


/* =========================================================

   REDES SOCIALES EN ABANICO

========================================================= */


.footer-redes-area {

    position: relative;

    width: 175px;

    height: 47px;

}


.footer-redes-boton {

    position: relative;

    z-index: 5;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    width: 145px;

    height: 38px;

    border: 1px solid rgba(255,255,255,.25);

    border-radius: 8px;

    background: rgba(255,255,255,.08);

    color: #ffffff;

    font-size: .81rem;

    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;

}


.footer-redes-boton:hover {

    background: #1769c2;

    border-color: #75bdff;

}


.footer-redes-opciones {

    position: absolute;

    z-index: 4;

    left: 0;

    bottom: 38px;

    width: 175px;

    height: 112px;

    pointer-events: none;

}


.footer-red-social {

    position: absolute;

    left: 55px;

    bottom: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    width: 39px;

    height: 39px;

    border: 2px solid #ffffff;

    border-radius: 50%;

    background: #174477;

    color: #ffffff;

    font-size: 1.05rem;

    text-decoration: none;

    opacity: 0;

    transform: translate(0, 12px) scale(.65);

    transition: opacity .22s ease, transform .28s ease, background .2s ease;

}


.footer-red-social:nth-child(1) {

    --x: -45px;

    --y: -18px;

}


.footer-red-social:nth-child(2) {

    --x: -17px;

    --y: -63px;

}


.footer-red-social:nth-child(3) {

    --x: 22px;

    --y: -63px;

}


.footer-red-social:nth-child(4) {

    --x: 50px;

    --y: -18px;

}


.footer-redes-area:hover .footer-red-social,

.footer-redes-area:focus-within .footer-red-social {

    opacity: 1;

    pointer-events: auto;

    transform: translate(var(--x), var(--y)) scale(1);

}


.footer-red-social:hover {

    background: #2588e8;

    color: #ffffff;

    transform: translate(var(--x), var(--y)) scale(1.12);

}


/* Franja inferior */

.footer-final {

    max-width: 1250px;

    margin: 8px auto 0;

    padding-top: 7px;

    border-top: 1px solid rgba(255,255,255,.15);

    text-align: center;

    color: #b9cce4;

    font-size: .69rem;

}


/* =========================================================

   RESPONSIVE

========================================================= */


@media (max-width: 900px) {

    .inicio-contenido {

        grid-template-columns: 1fr;

    }


    .carrusel-contenedor {

        min-height: 330px;

    }


    .carrusel,

    .carrusel .carousel-inner,

    .carrusel .carousel-item {

        min-height: 320px;

    }


    .carrusel img {

        height: 330px;

    }


    .panel-tarjetas {

        display: grid;

        grid-template-columns: repeat(3, 1fr);

    }


    .tarjeta-inicio {

        align-items: flex-start;

        flex-direction: column;

    }


    .footer-contenido {

        gap: 18px;

    }

}


@media (max-width: 650px) {

    .inicio-principal {

        padding: 18px 14px 22px;

    }


    .presentacion {

        margin-bottom: 15px;

    }


    .presentacion h1 {

        font-size: 1.8rem;

    }


    .presentacion p {

        font-size: .86rem;

    }


    .carrusel-contenedor {

        min-height: 290px;

    }


    .carrusel,

    .carrusel .carousel-inner,

    .carrusel .carousel-item {

        min-height: 280px;

    }


    .carrusel img {

        height: 290px;

    }


    .carrusel-texto {

        left: 20px;

        right: 20px;

        bottom: 30px;

    }


    .carrusel-texto h2 {

        font-size: 1.35rem;

    }


    .carrusel-texto p {

        font-size: .78rem;

    }


    .panel-tarjetas {

        grid-template-columns: 1fr;

    }
    .tarjeta-inicio {
        flex-direction: row;
        align-items: center;
    }
    .frase h2 {
        font-size: 1.1rem;
    }
    .footer-contenido {
        grid-template-columns: 1fr;
        gap: 13px;
    }
    .footer-columna:last-child {
        grid-column: auto;
    }
    .footer-ventana {
        width: min(260px, 85vw);
    }
    .footer-mapa-ventana {
        width: min(300px, 88vw);
    }

}
</style>
</head>
<body>



    <header class="top-band">



        <div class="top-band-inner">



            <div class="brand-area">



                <a

                    href="{{ url('/') }}"

                    class="brand-link"

                    aria-label="Inicio"

                >



                    <img

                        src="{{ asset('images/LITP.png') }}"

                        alt="Logo Instituto Tecnológico de Pachuca"

                    >



                    <div class="brand-separator"></div>



                    <div class="top-title">

                        Control de Tutorías ITP

                    </div>



                </a>



            </div>



            @if(session('user_name'))



                <div class="header-user">



                    <div class="dropdown">



                        <button

                            class="header-user-toggle dropdown-toggle"

                            type="button"

                            data-bs-toggle="dropdown"

                            aria-expanded="false"

                        >



                            {{-- Nombre y rol --}}



                            <span class="header-user-info">



                                <span class="header-user-name">



                                    {{ session('user_name') }}



                                </span>



                                <span class="header-user-role">

|

                                    {{ session('user_role', 'Usuario') }}



                                </span>



                            </span>



                        </button>



                        <ul class="dropdown-menu dropdown-menu-end header-user-menu">



                            <li>



                                <form

                                    action="{{ route('logout') }}"

                                    method="POST"

                                    class="m-0"

                                >



                                    @csrf



                                    <button

                                        type="submit"

                                        class="dropdown-item logout-item"

                                    >



                                        <i class="bi bi-box-arrow-right me-2"></i>



                                        Salir



                                    </button>



                                </form>



                            </li>



                        </ul>



                    </div>



                </div>





            @else



                <a

                    href="{{ route('login') }}"

                    class="header-login"

                >



                    <i class="bi bi-box-arrow-in-right"></i>



                    <span>

                        Iniciar sesión

                    </span>



                </a>



            @endif





        </div>



    </header>



    @hasSection('subnav')



        <nav class="subnav">



            <div class="container">



                <ul class="nav">



                    @yield('subnav')



                </ul>



            </div>



        </nav>



    @endif



    <main class="app-main">



        <div class="app-content">



            @yield('content')



        </div>



    </main>

<footer class="footer-itp">



    <div class="footer-contenido">



        {{-- DIRECCIÓN Y CONTACTO --}}

        <div class="footer-columna">



            <h6 class="footer-titulo">Información institucional</h6>



            {{-- DIRECCIÓN --}}

            <div class="footer-interactivo">



                <button class="footer-disparador" type="button">

                    <i class="bi bi-geo-alt-fill"></i>

                    Dirección

                    <i class="bi bi-chevron-down"></i>

                </button>



                <div class="footer-ventana">

                    <strong>Instituto Tecnológico de Pachuca</strong>



                    <p>

                        Carretera México - Pachuca km. 87.5,<br>

                        C.P. 42080, Colonia Venta Prieta,<br>

                        Pachuca de Soto, Hidalgo, México.

                    </p>

                </div>



            </div>



            <br>



            {{-- CONTACTO --}}

            <div class="footer-interactivo">



                <button class="footer-disparador" type="button">

                    <i class="bi bi-envelope-fill"></i>

                    Contacto

                    <i class="bi bi-chevron-down"></i>

                </button>



                <div class="footer-ventana">

                    <strong>Medios de contacto</strong>



                    <p>

                        <i class="bi bi-envelope"></i>

                        <a href="mailto:web_pachuca@tecnm.mx">

                            web_pachuca@tecnm.mx

                        </a>



                        <br><br>



                        <i class="bi bi-telephone-fill"></i>

                        771 711 3073<br>

                        771 711 3596<br>

                        771 711 5119<br>

                        771 711 3399

                    </p>

                </div>



            </div>



        </div>





        {{-- MAPA --}}

        <div class="footer-columna">



            <h6 class="footer-titulo">Ubicación</h6>



            <div class="footer-interactivo">



                <button class="footer-disparador" type="button">

                    <i class="bi bi-map-fill"></i>

                    Explorar ubicación

                    <i class="bi bi-chevron-down"></i>

                </button>



                <div class="footer-ventana footer-mapa-ventana">



                    <strong>Encuéntranos en Pachuca</strong>



                    <iframe

                        src="https://maps.google.com/maps?q=Instituto%20Tecnol%C3%B3gico%20de%20Pachuca&t=&z=15&ie=UTF8&iwloc=&output=embed"

                        loading="lazy"

                        referrerpolicy="no-referrer-when-downgrade"

                        title="Mapa del Instituto Tecnológico de Pachuca">

                    </iframe>



                    <a class="footer-mapa-enlace"

                       href="https://www.google.com/maps/search/?api=1&query=Instituto+Tecnol%C3%B3gico+de+Pachuca"

                       target="_blank"

                       rel="noopener noreferrer">
                        Abrir en Google Maps

                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- REDES SOCIALES --}}
        <div class="footer-columna">

            <h6 class="footer-titulo">Redes sociales</h6>

            <div class="footer-redes-area">

                <button class="footer-redes-boton" type="button">

                    <i class="bi bi-share-fill"></i>

                    Síguenos

                </button>

                <div class="footer-redes-opciones">

                    {{-- SITIO OFICIAL --}}

                    <a href="https://itp.itpachuca.edu.mx/"

                       target="_blank"

                       rel="noopener noreferrer"

                       class="footer-red-social"

                       aria-label="Sitio oficial"

                       title="Sitio oficial">

                        <i class="bi bi-globe"></i>
                    </a>

                    {{-- FACEBOOK --}}

                    <a href="https://www.facebook.com/people/TecNM-Pachuca/61557528505129/"

                       target="_blank"

                       rel="noopener noreferrer"

                       class="footer-red-social"

                       aria-label="Facebook TecNM Pachuca"

                       title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>

                    {{-- X --}}

                    <a href="https://x.com/tecnmpachuca"

                       target="_blank"

                       rel="noopener noreferrer"

                       class="footer-red-social"

                       aria-label="X TecNM Pachuca"
                       title="X">

                        <i class="bi bi-twitter-x"></i>
                    </a>

                    {{-- YOUTUBE --}}

                    <a href="https://www.youtube.com/@TecNMCampusPachuca"

                       target="_blank"

                       rel="noopener noreferrer"

                       class="footer-red-social"

                       aria-label="YouTube TecNM Campus Pachuca"

                       title="YouTube">
                        <i class="bi bi-youtube"></i>

                    </a>

                </div>

            </div>

        </div>
    </div>

    {{-- PIE FINAL SIN CONTADOR --}}

    <div class="footer-final">

        Instituto Tecnológico de Pachuca · TecNM
    </div>

</footer>

    <script

        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"

    ></script>
    @stack('scripts')

</body>

</html>