@extends('layouts.app')

@section('content')
<div class="text-center py-20">
    <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight">Welcome to LogicallyDebate</h1>
    <p class="mt-4 text-xl text-gray-500">The arena where logic rules and facts decide the winner.</p>
    
    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-indigo-500">
            <h3 class="text-lg font-bold">Argue</h3>
            <p class="mt-2 text-gray-600">Join as a Pro or Con person and defend your stance.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500">
            <h3 class="text-lg font-bold">Judge</h3>
            <p class="mt-2 text-gray-600">Analyze arguments and declare the logical winner.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-purple-500">
            <h3 class="text-lg font-bold">Observe</h3>
            <p class="mt-2 text-gray-600">Watch live debates and learn critical thinking.</p>
        </div>
    </div>
</div>

<!-- POPUP MODAL -->
<div id="authModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Login Required</h3>
            
            <!-- TABS -->
            <div class="flex justify-center mt-4 border-b">
                <button onclick="switchTab('login')" id="btnLoginTab" class="px-4 py-2 text-indigo-600 border-b-2 border-indigo-600 font-bold">Login</button>
                <button onclick="switchTab('register')" id="btnRegTab" class="px-4 py-2 text-gray-500">Register</button>
            </div>

            <div class="mt-2 px-4 py-4">
                <!-- ERROR MESSAGE CONTAINER -->
                <div id="errorMsg" class="hidden bg-red-100 text-red-700 p-2 rounded text-sm mb-2"></div>
                <div id="successMsg" class="hidden bg-green-100 text-green-700 p-2 rounded text-sm mb-2"></div>

                <!-- LOGIN FORM -->
                <form id="loginForm" onsubmit="handleLogin(event)">
                    <input type="email" id="loginEmail" placeholder="Email" class="w-full px-3 py-2 border rounded mb-2" required>
                    <input type="password" id="loginPass" placeholder="Password" class="w-full px-3 py-2 border rounded mb-2" required>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Login</button>
                </form>

                <!-- REGISTER FORM -->
                <form id="registerForm" class="hidden" onsubmit="handleRegister(event)">
                    <input type="text" id="regName" placeholder="Full Name" class="w-full px-3 py-2 border rounded mb-2" required>
                    <input type="email" id="regEmail" placeholder="Email" class="w-full px-3 py-2 border rounded mb-2" required>
                    <input type="password" id="regPass" placeholder="Password (Min 8 chars)" class="w-full px-3 py-2 border rounded mb-2" required>
                    <input type="password" id="regPassConfirm" placeholder="Confirm Password" class="w-full px-3 py-2 border rounded mb-2" required>
                    <select id="regRole" class="w-full px-3 py-2 border rounded mb-2" required>
                        <option value="user">User</option>
                        <option value="judge">Judge</option>
                        <option value="pro_person">Pro Person</option>
                        <option value="con_person">Con Person</option>
                    </select>
                    <p class="text-xs text-left text-gray-500 mb-2">* Special roles require Admin Approval</p>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Show Popup after 1 minute (60000ms)
    // For testing, change 60000 to 1000 (1 second)
    setTimeout(function() {
        @guest
            document.getElementById('authModal').classList.remove('hidden');
        @endguest
    }, 60000); 

    function switchTab(tab) {
        const loginForm = document.getElementById('loginForm');
        const regForm = document.getElementById('registerForm');
        const loginBtn = document.getElementById('btnLoginTab');
        const regBtn = document.getElementById('btnRegTab');

        if(tab === 'login'){
            loginForm.classList.remove('hidden');
            regForm.classList.add('hidden');
            loginBtn.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600', 'font-bold');
            loginBtn.classList.remove('text-gray-500');
            regBtn.classList.add('text-gray-500');
            regBtn.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600', 'font-bold');
        } else {
            loginForm.classList.add('hidden');
            regForm.classList.remove('hidden');
            regBtn.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600', 'font-bold');
            regBtn.classList.remove('text-gray-500');
            loginBtn.classList.add('text-gray-500');
            loginBtn.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600', 'font-bold');
        }
    }

    async function handleLogin(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPass').value;
        const errorDiv = document.getElementById('errorMsg');

        try {
            const response = await fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email, password })
            });
            const data = await response.json();

            if(data.success) {
                window.location.href = data.redirect;
            } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove('hidden');
            }
        } catch(err) {
            console.error(err);
        }
    }

    async function handleRegister(e) {
        e.preventDefault();
        const name = document.getElementById('regName').value;
        const email = document.getElementById('regEmail').value;
        const password = document.getElementById('regPass').value;
        const password_confirmation = document.getElementById('regPassConfirm').value;
        const role = document.getElementById('regRole').value;
        
        const errorDiv = document.getElementById('errorMsg');
        const successDiv = document.getElementById('successMsg');

        try {
            const response = await fetch("{{ route('register') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ name, email, password, password_confirmation, role })
            });
            const data = await response.json();

            if(data.success) {
                successDiv.innerText = data.message;
                successDiv.classList.remove('hidden');
                errorDiv.classList.add('hidden');
                document.getElementById('registerForm').reset();
            } else {
                errorDiv.innerText = data.message || "Registration failed.";
                errorDiv.classList.remove('hidden');
                successDiv.classList.add('hidden');
            }
        } catch(err) {
             // Handle validation errors usually sent as 422
             errorDiv.innerText = "Check your inputs (Email unique? Password match?)";
             errorDiv.classList.remove('hidden');
        }
    }
</script>
@endsection