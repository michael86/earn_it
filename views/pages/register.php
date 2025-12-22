<?php
$type = $_GET['type'] ?? '';
$type = in_array($type, ['parent', 'child'], true) ? $type : '';

loadPartial('head');
loadPartial('nav');
?>

<main class="py-16">
    <div class="mx-auto max-w-2xl px-4">

        <div class="rounded-xl bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">
                Create an account
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                Choose your role and get started. Each family has their own private space.
            </p>

            <!-- Role picker -->
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                <a href="/register?type=parent"
                    class="rounded-lg border px-4 py-3 text-left hover:bg-gray-50 <?= $type === 'parent' ? 'border-blue-600 ring-1 ring-blue-600' : 'border-gray-200' ?>">
                    <div class="font-semibold">Parent</div>
                    <div class="mt-1 text-sm text-gray-600">
                        Assign tasks and approve completions.
                    </div>
                </a>

                <a href="/register?type=child"
                    class="rounded-lg border px-4 py-3 text-left hover:bg-gray-50 <?= $type === 'child' ? 'border-blue-600 ring-1 ring-blue-600' : 'border-gray-200' ?>">
                    <div class="font-semibold">Child</div>
                    <div class="mt-1 text-sm text-gray-600">
                        Complete tasks and earn points.
                    </div>
                </a>
            </div>

            <!-- Form -->
            <form class="mt-8 space-y-5" method="post" action="/register">
                <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            First name
                        </label>
                        <input
                            type="text"
                            name="first_name"
                            autocomplete="given-name"
                            required
                            class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                            placeholder="First name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Last name
                        </label>
                        <input
                            type="text"
                            name="last_name"
                            autocomplete="family-name"
                            required
                            class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                            placeholder="Last name">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <input
                        type="email"
                        name="email"
                        autocomplete="email"
                        required
                        class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                        placeholder="you@example.com">
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            required
                            class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                            placeholder="Create a password">
                        <p class="mt-2 text-xs text-gray-500">
                            Use at least 8 characters.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Confirm password
                        </label>
                        <input
                            type="password"
                            name="password_confirm"
                            autocomplete="new-password"
                            required
                            class="mt-1 w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                            placeholder="Repeat password">
                    </div>
                </div>

                <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <div class="flex items-start gap-2">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the terms and privacy policy.
                        </label>
                    </div>

                    <p class="text-xs text-gray-500">
                        Parents and children accounts are kept within a single family group. No other family can view your information.
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">
                    Create account
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="font-semibold text-blue-600 hover:text-blue-700">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</main>

<?php loadPartial('footer'); ?>