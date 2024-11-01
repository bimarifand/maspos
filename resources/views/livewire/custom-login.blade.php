<div class="min-h-screen bg-white flex items-center justify-center p-4 relative">
    <div class="absolute w-full h-1/2 top-0 left-0 bg-[#0052CC] z-0 px-8">
        <div class="flex justify-between items-center max-w-7xl mx-auto py-8">
            <a  href="{{route('home')}}" wire:navigate wire:navigate class="text-3xl font-bold text-white">MAS POS</a>
            <p class="text-white">Call Us  +62 817-1902-092</p>
        </div>
    </div>
    <div class="w-5/6 sm:w-[500px] min-h-[400px] bg-white rounded-[10px] shadow-card-shadow relative z-10 p-12">
        <!-- Logo Section -->
        <div class="text-center mb-12">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Login
            </h2>
        </div>

        <!-- Login Form -->
        <form wire:submit="authenticate" class="space-y-6">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <div class="mt-1">
                    <input
                        wire:model="email"
                        id="email"
                        type="email"
                        required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#4C9AFF] focus:border-[#4C9AFF] sm:text-sm"
                    >
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <div class="mt-1">
                    <input
                        wire:model="password"
                        id="password"
                        type="password"
                        required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#4C9AFF] focus:border-[#4C9AFF] sm:text-sm"
                    >
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button
                    type="submit"
                    class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0052CC] hover:bg-[#0025cc] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4C9AFF]"
                >
                    <div wire:loading.remove wire:target="authenticate">
                        Login
                    </div>
                    <div wire:loading wire:target="authenticate">
                        Processing...
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>