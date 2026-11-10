@extends('layouts.school')

@section('title', 'Admissions | Amiru International School')

@section('content')
<main class="form-page admissions-page">
    <div class="form-intro">
        <p class="eyebrow">ADMISSIONS · AMIRU INTERNATIONAL SCHOOL</p>
        <h1>Start their <em>next chapter.</em></h1>
        <p>Share a few details to begin an application. Our admissions team will follow up with you.</p>
        <div class="login-aside"><span class="aside-icon">✳</span><p>A warm welcome starts here.<br><small>Complete this form and keep your application number for follow-up.</small></p></div>
    </div>
    <div>
        @if (session('application_number'))
            <div class="success-card" role="status">
                <span class="success-mark">✓</span>
                <p class="eyebrow">APPLICATION RECEIVED</p>
                <h2>Thank you for applying.</h2>
                <p>Your application number is <strong>{{ session('application_number') }}</strong>. Please save it for your records.</p>
            </div>
        @else
            <form class="school-form application-form" method="POST" action="{{ route('admissions.store') }}">
                @csrf
                <p class="eyebrow">ONLINE APPLICATION</p>
                <h2>Tell us about your learner</h2>
                <div class="field-grid">
                    <div><label for="first_name">First name</label><input id="first_name" name="first_name" value="{{ old('first_name') }}" required>@error('first_name')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="last_name">Last name</label><input id="last_name" name="last_name" value="{{ old('last_name') }}" required>@error('last_name')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="date_of_birth">Date of birth</label><input id="date_of_birth" name="date_of_birth" type="date" max="{{ now()->subDay()->format('Y-m-d') }}" value="{{ old('date_of_birth') }}" required>@error('date_of_birth')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="gender">Gender</label><select id="gender" name="gender" required><option value="">Select</option><option value="female" @selected(old('gender') === 'female')>Female</option><option value="male" @selected(old('gender') === 'male')>Male</option><option value="prefer_not_to_say" @selected(old('gender') === 'prefer_not_to_say')>Prefer not to say</option></select>@error('gender')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="applying_for">Grade / class applying for</label><input id="applying_for" name="applying_for" value="{{ old('applying_for') }}" placeholder="e.g. Year 1" required>@error('applying_for')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="previous_school">Previous school <span>(optional)</span></label><input id="previous_school" name="previous_school" value="{{ old('previous_school') }}">@error('previous_school')<p class="field-error">{{ $message }}</p>@enderror</div>
                </div>
                <div class="form-divider"></div>
                <h3>Parent or guardian</h3>
                <label for="guardian_name">Full name</label><input id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" required>@error('guardian_name')<p class="field-error">{{ $message }}</p>@enderror
                <div class="field-grid">
                    <div><label for="guardian_email">Email address</label><input id="guardian_email" name="guardian_email" type="email" value="{{ old('guardian_email') }}" required>@error('guardian_email')<p class="field-error">{{ $message }}</p>@enderror</div>
                    <div><label for="guardian_phone">Phone number</label><input id="guardian_phone" name="guardian_phone" type="tel" value="{{ old('guardian_phone') }}" required>@error('guardian_phone')<p class="field-error">{{ $message }}</p>@enderror</div>
                </div>
                <button class="button button-green button-full" type="submit">Submit application <span aria-hidden="true">↗</span></button>
                <p class="form-help">Your details will be shared with the school admissions team.</p>
            </form>
        @endif
    </div>
</main>
@endsection
