<?php

loadPartial('head');

?>

<body class="min-h-screen bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
            <h1 class="text-xl font-bold">Earn It</h1>

            <nav class="space-x-4 text-sm">
                <a href="/" class="text-gray-600 hover:text-gray-900">Home</a>
                <a href="/contact" class="text-gray-600 hover:text-gray-900">Contact</a>
                <a href="/login" class="text-gray-600 hover:text-gray-900">Login</a>
            </nav>
        </div>
    </header>

    <!-- Main -->
    <main class="py-16">
        <div class="mx-auto max-w-4xl px-4">

            <h2 class="text-3xl font-bold text-center">
                About Earn It
            </h2>

            <p class="mt-6 text-center text-gray-600">
                Earn It is designed to help families build healthy habits, responsibility, and motivation in a fun and rewarding way.
            </p>

            <!-- Content blocks -->
            <div class="mt-12 space-y-10">

                <section class="rounded-xl bg-white p-8 shadow-sm">
                    <h3 class="text-xl font-semibold">
                        Our idea
                    </h3>
                    <p class="mt-3 text-gray-600">
                        We wanted to create a simple system where everyday tasks turn into meaningful rewards.
                        Parents can clearly assign responsibilities, and children can see their progress build towards something they truly want.
                    </p>
                </section>

                <section class="rounded-xl bg-white p-8 shadow-sm">
                    <h3 class="text-xl font-semibold">
                        Built for families
                    </h3>
                    <p class="mt-3 text-gray-600">
                        Earn It is built around the family unit. Each family has their own private space where tasks, points, and wish lists stay secure and separate.
                        No outside interference, no confusion.
                    </p>
                </section>

                <section class="rounded-xl bg-white p-8 shadow-sm">
                    <h3 class="text-xl font-semibold">
                        Simple and fair
                    </h3>
                    <p class="mt-3 text-gray-600">
                        Everything is designed to be clear and transparent. Tasks have defined rewards, progress is visible, and achievements feel earned.
                        It is about building trust as much as motivation.
                    </p>
                </section>

            </div>
        </div>
    </main>

    <?php loadPartial('footer'); ?>