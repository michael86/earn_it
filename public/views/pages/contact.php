<?php
loadPartial('head');
loadPartial('nav');
?>



<!-- Main -->
<main class="py-16">
    <div class="mx-auto max-w-3xl px-4">
        <h2 class="text-3xl font-bold text-center">
            Contact us
        </h2>

        <p class="mt-4 text-center text-gray-600">
            Got a question or need help setting things up? Drop us a message and we will get back to you.
        </p>

        <!-- Contact form -->
        <form class="mt-10 space-y-6 rounded-xl bg-white p-8 shadow-sm">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Name
                </label>
                <input
                    type="text"
                    class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Your name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <input
                    type="email"
                    class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="you@example.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Message
                </label>
                <textarea
                    rows="5"
                    class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="How can we help?"></textarea>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
                    Send message
                </button>
            </div>
        </form>
    </div>
</main>
<?php loadPartial('footer'); ?>