@extends('layouts.app')


@section('title', 'Inicio')


@section('content')


<style>

/* =========================================================

   PÁGINA DE INICIO

========================================================= */


.inicio-principal {
    width: 100%;
    max-width: 1400px;
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
/* Ajustes finales: etiqueta y espacio antes del pie */
@media (min-width: 901px) {
    .presentacion .etiqueta {
        position: relative;
        top: -5px;
        margin-bottom: 3px;
    }

    .inicio-principal {
        padding-bottom:20px !important;
    }

    main.app-main:has(.inicio-principal) {
        flex: 0 0 auto !important;
        padding-bottom: 2px !important;
    }

    .footer-itp {
        margin-top: 2px !important;
    }
}

</style>


<div class="inicio-principal">


    {{-- BIENVENIDA --}}

    <section class="presentacion">


        <div class="etiqueta">

            <i class="bi bi-mortarboard-fill"></i>

            Comunidad Tecnológica

        </div>


        <h1>¡BIENVENIDOS!</h1>


        <p>

            Un espacio institucional para acompañar,

            orientar y fortalecer la trayectoria de nuestra

            comunidad estudiantil.

        </p>


    </section>


    {{-- CONTENIDO: CARRUSEL A LA IZQUIERDA Y TARJETAS A LA DERECHA --}}

    <section class="inicio-contenido">


        {{-- CARRUSEL --}}

        <div class="carrusel-contenedor">


            <div id="carruselInicio"

                 class="carousel slide carrusel"

                 data-bs-ride="carousel"

                 data-bs-interval="5500">


                {{-- Indicadores --}}

                <div class="carousel-indicators">


                    <button type="button"

                            data-bs-target="#carruselInicio"

                            data-bs-slide-to="0"

                            class="active"

                            aria-current="true"

                            aria-label="Imagen 1"></button>


                    <button type="button"

                            data-bs-target="#carruselInicio"

                            data-bs-slide-to="1"

                            aria-label="Imagen 2"></button>


                    <button type="button"

                            data-bs-target="#carruselInicio"

                            data-bs-slide-to="2"

                            aria-label="Imagen 3"></button>


                </div>


                {{-- Imágenes --}}

                <div class="carousel-inner">


                    <div class="carousel-item active">


                        <img src="{{ asset('images/slide1.jpg') }}"

                             alt="Comunidad del Instituto Tecnológico de Pachuca">


                        <div class="carrusel-texto">

                            <span class="mini-titulo">Comunidad ITP</span>


                            <h2>Acompañamiento que transforma</h2>


                            <p>

                                Construimos juntos una experiencia académica

                                con orientación y apoyo.

                            </p>

                        </div>


                    </div>


                    <div class="carousel-item">


                        <img src="{{ asset('images/slide2.jpg') }}"

                             alt="Actividades institucionales">


                        <div class="carrusel-texto">

                            <span class="mini-titulo">Nuestra comunidad</span>


                            <h2>Crecemos juntos</h2>


                            <p>

                                La participación y el compromiso fortalecen

                                nuestra comunidad tecnológica.

                            </p>

                        </div>


                    </div>


                    <div class="carousel-item">


                        <img src="{{ asset('images/slide3.jpg') }}"

                             alt="Vida institucional">


                        <div class="carrusel-texto">

                            <span class="mini-titulo">Vida institucional</span>


                            <h2>Una comunidad que avanza</h2>


                            <p>

                                Formación, colaboración y acompañamiento

                                para nuestra comunidad estudiantil.

                            </p>

                        </div>


                    </div>


                </div>


                {{-- Anterior --}}

                <button class="carousel-control-prev"

                        type="button"

                        data-bs-target="#carruselInicio"

                        data-bs-slide="prev">


                    <span class="carousel-control-prev-icon"></span>

                    <span class="visually-hidden">Anterior</span>


                </button>


                {{-- Siguiente --}}

                <button class="carousel-control-next"

                        type="button"

                        data-bs-target="#carruselInicio"

                        data-bs-slide="next">


                    <span class="carousel-control-next-icon"></span>

                    <span class="visually-hidden">Siguiente</span>


                </button>


            </div>

        </div>


        {{-- TARJETAS --}}

        <div class="panel-tarjetas">


            <div class="tarjeta-inicio">


                <div class="icono-tarjeta">

                    <i class="bi bi-calendar-check-fill"></i>

                </div>


                <div class="tarjeta-texto">

                    <h3>Tutorías</h3>

                    <p>

                        Consulta y da seguimiento a las actividades

                        de tutoría durante tu trayectoria académica.

                    </p>

                </div>


            </div>


            <div class="tarjeta-inicio">
                <div class="icono-tarjeta">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="tarjeta-texto">

                    <h3>Acompañamiento</h3>

                    <p>
                        Fortalecemos la comunicación entre estudiantes,
                        tutores y responsables del programa.
                    </p>
                </div>
            </div>


            <div class="tarjeta-inicio">


                <div class="icono-tarjeta">

                    <i class="bi bi-bar-chart-fill"></i>

                </div>

                <div class="tarjeta-texto">

                    <h3>Seguimiento</h3>

                    <p>
                        Información organizada para facilitar el seguimiento
                        y la gestión del programa de tutorías.
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- FRASE INSTITUCIONAL --}}
</div>


@endsection