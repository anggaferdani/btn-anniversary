@extends('backend.templates.scan')
@section('title', 'Scan Kehadiran Participant')

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

            width: 150px; /* Increased width */
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
            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 3rem;
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

            <div class="door">
                <div class="boxes">
                    <!-- Kotak untuk pintu kedua -->
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
                const itemsDoor1 = {!! json_encode(array_keys($result)) !!};
                let itemsDoor2 = [];
                const doors = document.querySelectorAll(".door");
                let spinCount = 0

                document.addEventListener("keydown", function (event) {
                    if (event.code === "Space") {
                        spin();
                    } else if (event.code === "Enter") {
                        reset();
                    }
                });

                function updateDoor2Items(selectedLetter) {
                    switch (selectedLetter) {
                        case "B":
                            itemsDoor2 = {!! json_encode($result["B"] ?? []) !!};
                            break;
                        case "U":
                            itemsDoor2 = {!! json_encode($result["U"] ?? []) !!};
                            break;
                        case "M":
                            itemsDoor2 = {!! json_encode($result["M"] ?? []) !!};
                            break;
                        case "N":
                            itemsDoor2 = {!! json_encode($result["N"] ?? []) !!};
                            break;
                        default:
                            itemsDoor2 = [];
                    }
                }

                async function spin() {
                    if (spinCount == 1) {
                        var firstDoorResult;
                        const boxes = doors[0].querySelector(".boxes");
                        firstDoorResult = boxes.children[0].textContent;
                        updateDoor2Items(firstDoorResult);
                        await initSingleDoor(doors[1], false, 1, 2);
                        spinCount += 1;
                    } else if (spinCount == 0) {
                        init(false, 1, 2);
                        spinCount += 1;
                    }else if(spinCount == 2){
                        console.log('asdas')
                        const jsConfetti = new JSConfetti()
                        jsConfetti.addConfetti()
                    }


                }

                function reset() {
                    doors.forEach((door) => {
                        door.dataset.spinned = "0"; // Reset the spinned status
                    });
                    itemsDoor2 = [];
                    spinCount = 0
                    init(true, 1, 2); // Reset the doors
                }

                function init(firstInit = true, groups = 1, duration = 2) {
                    doors.forEach((door) => {
                        initSingleDoor(door, firstInit, groups, duration);
                    });
                }

                async function initSingleDoor(door, firstInit = true, groups = 1, duration = 1) {
                    if (firstInit) {
                        door.dataset.spinned = "0";
                    } else if (door.dataset.spinned === "1") {
                        return;
                    }

                    const boxes = door.querySelector(".boxes");
                    const boxesClone = boxes.cloneNode(false);

                    const pool = ["❓"];
                    const doorIndex = Array.from(doors).indexOf(door);
                    if (!firstInit) {
                        if (doorIndex === 0) {
                            pool.push(...shuffle(itemsDoor1));
                        } else if (doorIndex === 1) {
                            pool.push(...shuffle(itemsDoor2));
                        }
                    }

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
                            spin()

                            // console.log("doorIndex", doorIndex);
                        },
                        {once: true}
                    );

                    for (let i = pool.length - 1; i >= 0; i--) {
                        const box = document.createElement("div");
                        box.classList.add("box");
                        box.style.width = door.clientWidth + "px";
                        box.style.height = door.clientHeight + "px";
                        box.textContent = pool[i];
                        boxesClone.appendChild(box);
                    }

                    boxesClone.style.transitionDuration = `${duration > 0 ? duration : 1}s`;
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

                init();
            }

        )
        ();
    </script>
@endpush
