<?php
loadPartial('head');
loadPartial('nav');

?>


<main class="w-full px-4">
    <div class="mx-auto max-w-md text-center">

        <h1 class="text-6xl font-bold text-blue-600">
            403
        </h1>

        <h2 class="mt-4 text-2xl font-semibold">
            Access Denied
        </h2>

        <p class="mt-4 text-gray-600">
            Sorry, you do not have permission to access this page.
        </p>

        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
            <a
                href="/"
                class="rounded-md bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
                Go to home
            </a>

            <a
                href="/contact"
                class="rounded-md border border-gray-300 px-6 py-3 font-semibold text-gray-700 hover:bg-gray-100">
                Contact support
            </a>
        </div>

    </div>
</main>
<?php loadPartial('footer'); ?>