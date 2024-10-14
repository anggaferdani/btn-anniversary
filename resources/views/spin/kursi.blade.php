@extends('backend.templates.scan')
@section('title', 'SPIN')

@section('content')
    <style>
        html,
        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
            border: 0;
            padding: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        *,
        *::before,
        *::after {
            -webkit-box-sizing: inherit;
            -moz-box-sizing: inherit;
            box-sizing: inherit;
        }

        #app {
            width: 100%;
            height: 100%;

            /*background: #212121;*/

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .doors {
            display: flex;
        }

        .door {
            background: #fafafa;
            box-shadow: 0 0 3px 2px rgba(0, 0, 0, 0.4) inset;

            width: 350px; /* Increased width */
            height: 200px; /* Increased height */
            overflow: hidden;

            border-radius: 1ex;
            margin: 1ch;
        }

        .boxes {
            /* transform: translateY(0); */
            transition: transform 1s ease-in-out;
        }

        .box {
            /*font-size: 40px;*/
            display: flex;
            justify-content: center;
            align-items: center;
            letter-spacing: 20px;
            font-size: 5rem;
        }

        .buttons {
            margin: 1rem 0 2rem 0;
        }

        button {
            cursor: pointer;

            font-size: 1.2rem;
            text-transform: uppercase;

            margin: 0 0.2rem 0 0.2rem;
        }

        .info {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>

    <div class="container" style="transform: scale(1); transform-origin: top center;">
        <div class="col-md-4 m-auto mb-3 pt-4">
            <div class="text-center mb-3">
                <img src="{{ asset('assets/partner.png') }}" class="" width="180">
            </div>
            <div class="text-center mb-3">
                <img src="{{ asset('assets/final-event.png') }}" class="" width="250">
            </div>
        </div>

    </div>
    <div id="app">

        <div class="doors">
            <div class="door">
                <div class="boxes">
                    <!-- Kotak untuk pintu pertama -->
                </div>
            </div>


        </div>


        <p class="info"></p>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>

    <script>
        (function () {
            "use strict";
            const items = Array.from({length: 400}, (_, i) => i + 1);
            const door = document.querySelector(".door");
            let spinCount = 0;

            document.addEventListener("keydown", function (event) {
                if (event.code === "Space") {
                    spin();
                } else if (event.code === "Enter") {
                    reset();
                }
            });

            async function spin() {
                // if (spinCount === 0) {
                    await initSingleDoor(door, false);
                // spinCount++;

            }

            function reset() {
                door.dataset.spinned = "0";
                spinCount = 0;
                initSingleDoor(door, true);
            }

            async function initSingleDoor(door, firstInit = true, duration = 2) {
                if (firstInit) {
                    door.dataset.spinned = "0";
                } else if (door.dataset.spinned === "1") {
                    return;
                }

                const boxes = door.querySelector(".boxes");
                const boxesClone = boxes.cloneNode(false);

                const pool = firstInit ? ["❓"] : shuffle([...items]);

                boxesClone.addEventListener(
                    "transitionstart",
                    function () {
                        door.dataset.spinned = "1";
                        this.querySelectorAll(".box").forEach((box) => {
                            box.style.filter = "blur(1px)";
                        });
                    },
                    {once: true}
                );

                boxesClone.addEventListener(
                    "transitionend",
                    function () {
                        this.querySelectorAll(".box").forEach((box, index) => {
                            box.style.filter = "blur(0)";
                            if (index > 0) this.removeChild(box);
                        });
                        const jsConfetti = new JSConfetti();
                        jsConfetti.addConfetti();
                    },
                    {once: true}
                );

                for (let i = pool.length - 1; i >= 0; i--) {
                    const box = document.createElement("div");
                    box.classList.add("box");
                    box.classList.add("fw-bold");
                    box.style.width = door.clientWidth + "px";
                    box.style.height = door.clientHeight + "px";
                    box.textContent = pool[i];
                    boxesClone.appendChild(box);
                }

                boxesClone.style.transitionDuration = `${duration}s`;
                boxesClone.style.transform = `translateY(-${door.clientHeight * (pool.length - 1)}px)`;
                door.replaceChild(boxesClone, boxes);

                return new Promise((resolve) => {
                    setTimeout(() => {
                        boxesClone.style.transform = "translateY(0)";
                        resolve();
                    }, 0);
                });
            }

            function shuffle([...arr]) {
                let m = arr.length;
                while (m) {
                    const i = Math.floor(Math.random() * m--);
                    [arr[m], arr[i]] = [arr[i], arr[m]];
                }
                return arr;
            }

            initSingleDoor(door);
        })();
    </script>
@endpush
