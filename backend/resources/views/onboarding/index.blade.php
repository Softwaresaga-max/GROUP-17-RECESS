<x-guest-layout>

<style>
    .card {
        max-width: 650px;
        margin: auto;
        text-align: center;
        padding: 40px;
        font-family: Arial;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .progress-bar {
        width: 100%;
        background: #eee;
        height: 10px;
        border-radius: 20px;
        overflow: hidden;
        margin: 15px 0;
    }

    .progress {
        height: 10px;
        background: linear-gradient(90deg, #4CAF50, #2196F3);
        width: {{ ($step/3)*100 }}%;
        transition: 0.3s ease;
    }

    .step-title {
        font-size: 22px;
        margin-bottom: 10px;
    }

    .fade {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    button {
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        border: none;
    }

    .next {
        background: #2196F3;
        color: white;
    }

    .finish {
        background: #4CAF50;
        color: white;
    }

    .back {
        background: #ddd;
    }
</style>

<div class="card fade">

    <h1>🎓 EDUCONNECT Onboarding</h1>

    <h3>Step {{ $step }} of 3</h3>

    <!-- PROGRESS -->
    <div class="progress-bar">
        <div class="progress"></div>
    </div>

    <hr>

    <!-- STEP 1 -->
    @if($step == 1)
        <div class="fade">
            <div class="step-title">👋 Welcome</div>
            <p>
                You are about to join EDUCONNECT — a platform for discussions, quizzes, and academic collaboration.
            </p>
        </div>
    @endif

    <!-- STEP 2 -->
    @if($step == 2)
        <div class="fade">
            <div class="step-title">📌 System Rules</div>

            <ul style="list-style:none; padding:0;">
                <li>✔ Respect all discussions</li>
                <li>✔ Participate actively in forums</li>
                <li>⚠️ 2 warnings = automatic blacklist</li>
                <li>⚠️ Late joining may limit participation</li>
            </ul>
        </div>
    @endif

    <!-- STEP 3 -->
    @if($step == 3)
    <div class="fade">

        <div class="step-title">📜 Platform Rules Acceptance</div>

        <p>Please read and accept the rules to continue:</p>

        <ul style="text-align:left;">
            <li>✔ Respect all users</li>
            <li>✔ No spam or cheating</li>
            <li>✔ Violations may lead to account suspension</li>
        </ul>

        <form method="POST" action="{{ route('onboarding.complete') }}">
            @csrf

            <button name="action" value="accept" class="finish">
                ✅ Accept & Continue
            </button>

            <button name="action" value="decline" class="back">
                ❌ Decline
            </button>
        </form>

    </div>
@endif

    <hr>

    <!-- BUTTONS -->
    <div style="display:flex; justify-content:space-between;">

        <div>
            @if($step > 1)
                <form method="POST" action="{{ route('onboarding.back') }}">
                    @csrf
                    <button class="back">⬅ Back</button>
                </form>
            @endif
        </div>

        <div>
            @if($step < 3)
                <form method="POST" action="{{ route('onboarding.next') }}">
                    @csrf
                    <button class="next">Next ➡</button>
                </form>
            @else
                <form method="POST" action="{{ route('onboarding.complete') }}">
                    @csrf
                    <button class="finish">Finish 🎉</button>
                </form>
            @endif
        </div>

    </div>

</div>

</x-guest-layout>