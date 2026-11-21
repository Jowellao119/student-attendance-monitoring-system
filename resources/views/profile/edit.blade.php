@extends('layouts.app')

@section('title', 'Profile Settings - StudentTrack')
@section('page-title', 'Profile Settings')
@section('page-subtitle', 'Manage your account information and security')

@push('styles')
<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .profile-intro {
        background: linear-gradient(120deg, #6246a5, #a34d91);
        color: white;
        padding: 25px 28px;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .profile-intro h2 {
        font-size: 23px;
        margin-bottom: 8px;
    }

    .profile-intro p {
        font-size: 14px;
        opacity: .9;
    }

    .profile-card {
        background: white;
        padding: 28px;
        border-radius: 13px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(30, 30, 60, .04);
    }

    .profile-card h3 {
        color: #252b3b;
        font-size: 18px;
        margin-bottom: 8px;
    }

    .profile-card > p {
        color: #858b9a;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .profile-card form {
        max-width: 650px;
    }

    .profile-card label {
        display: block;
        color: #555e70;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .profile-card input {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #e5e7ef;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .profile-card input:focus {
        border-color: #8062bd;
        box-shadow: 0 0 0 3px rgba(128, 98, 189, .1);
    }

    .profile-card button {
        background: linear-gradient(135deg, #6246a5, #9b59b6);
        color: white;
        padding: 11px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .profile-card button:hover {
        opacity: .9;
    }

    .profile-card .danger-button {
        background: #c0392b;
    }

    .profile-card .danger-button:hover {
        background: #a93226;
    }

    .profile-card .text-sm {
        font-size: 13px;
        color: #858b9a;
    }

    .profile-card .text-gray-600 {
        color: #858b9a;
    }

    .profile-card .text-gray-900 {
        color: #252b3b;
    }

    .profile-card .text-red-600 {
        color: #c0392b;
    }

    .profile-card .text-green-600 {
        color: #219653;
    }

    .profile-card .mt-2 {
        margin-top: 8px;
    }

    .profile-card .mt-4 {
        margin-top: 16px;
    }

    .profile-card .mt-6 {
        margin-top: 24px;
    }

    .profile-card .flex {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .profile-card .underline {
        text-decoration: underline;
    }

    .profile-card button:focus {
        outline: 2px solid #8062bd;
        outline-offset: 2px;
    }

    @media (max-width: 650px) {
        .profile-card {
            padding: 20px;
        }

        .profile-intro {
            padding: 22px;
        }
    }
</style>
@endpush

@section('content')

<div class="profile-container">

    <section class="profile-intro">
        <h2>Account Settings</h2>
        <p>Update your personal information, password, and account settings.</p>
    </section>

    <section class="profile-card">
        <h3>Profile Information</h3>
        <p>Update your account name and email address.</p>

        @include('profile.partials.update-profile-information-form')
    </section>

    <section class="profile-card">
        <h3>Update Password</h3>
        <p>Make sure your account uses a strong and secure password.</p>

        @include('profile.partials.update-password-form')
    </section>

    <section class="profile-card">
        <h3>Delete Account</h3>
        <p>Delete your account and its associated information.</p>

        @include('profile.partials.delete-user-form')
    </section>

</div>

@endsection
