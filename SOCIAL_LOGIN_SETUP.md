# Social Login Setup Guide

## 📋 Prerequisites

Before setting up social login, make sure you have:

1. Laravel Socialite package installed
2. API credentials from Google, Facebook, and LinkedIn

## 🚀 Installation Steps

### Step 1: Install Laravel Socialite

```bash
composer require laravel/socialite
```

### Step 2: Run Migration

```bash
php artisan migrate
```

This will add the following columns to your `users` table:

-   `provider` (string, nullable)
-   `provider_id` (string, nullable)
-   `avatar` (string, nullable)

### Step 3: Configure Environment Variables

Add the following to your `.env` file:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URI=${APP_URL}/auth/facebook/callback

# LinkedIn OAuth
LINKEDIN_CLIENT_ID=your-linkedin-client-id
LINKEDIN_CLIENT_SECRET=your-linkedin-client-secret
LINKEDIN_REDIRECT_URI=${APP_URL}/auth/linkedin/callback
```

## 🔑 Getting API Credentials

### Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API
4. Go to "Credentials" → "Create Credentials" → "OAuth 2.0 Client IDs"
5. Set Application type to "Web application"
6. Add Authorized redirect URIs:
    - `http://localhost/auth/google/callback` (for local)
    - `https://yourdomain.com/auth/google/callback` (for production)
7. Copy Client ID and Client Secret

### Facebook OAuth Setup

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app or select existing one
3. Add "Facebook Login" product
4. Go to Settings → Basic
5. Copy App ID and App Secret
6. Go to Facebook Login → Settings
7. Add Valid OAuth Redirect URIs:
    - `http://localhost/auth/facebook/callback` (for local)
    - `https://yourdomain.com/auth/facebook/callback` (for production)

### LinkedIn OAuth Setup

1. Go to [LinkedIn Developers](https://www.linkedin.com/developers/)
2. Create a new app
3. Go to "Auth" tab
4. Copy Client ID and Client Secret
5. Add Redirect URLs:
    - `http://localhost/auth/linkedin/callback` (for local)
    - `https://yourdomain.com/auth/linkedin/callback` (for production)
6. Under "Products", request access to "Sign In with LinkedIn"

## 🔧 Configuration Files

The configuration is already set up in:

-   `config/services.php` - Social provider configurations
-   `routes/web.php` - Social auth routes
-   `app/Http/Controllers/SocialAuthController.php` - Social auth logic

## 📝 Routes

The following routes are available:

```php
// Redirect to social provider
GET /auth/{provider}/redirect
// Supported providers: google, facebook, linkedin

// Handle callback from social provider
GET /auth/{provider}/callback
```

## 🎯 Usage

Users can now click on the Google, Facebook, or LinkedIn buttons on the login page to authenticate using their social accounts.

### How it works:

1. User clicks on social login button
2. User is redirected to the social provider's login page
3. User authenticates and grants permission
4. Provider redirects back to your app with user info
5. App creates/updates user account and logs them in
6. User is redirected to dashboard

## 🔒 Security Features

-   Email verification is automatically set for social login users
-   Random strong passwords are generated for social accounts
-   Provider ID is stored to prevent duplicate accounts
-   Existing users can link their social accounts

## 🐛 Troubleshooting

### "Invalid social provider" error

-   Make sure you're using one of: google, facebook, linkedin

### "Unable to authenticate" error

-   Check if your API credentials are correct in `.env`
-   Verify redirect URIs match in provider settings and your app
-   Make sure the provider app is in production mode (not development)

### "Email already exists" error

-   The system will automatically link the social account to existing email

## 📚 Additional Resources

-   [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
-   [Google OAuth Documentation](https://developers.google.com/identity/protocols/oauth2)
-   [Facebook Login Documentation](https://developers.facebook.com/docs/facebook-login)
-   [LinkedIn OAuth Documentation](https://docs.microsoft.com/en-us/linkedin/shared/authentication/authentication)

## ✅ Testing

To test social login locally:

1. Make sure your `.env` has correct credentials
2. Use `http://localhost` or configure your local domain
3. Test each provider separately
4. Check if user data is correctly stored in database

## 🎉 That's it!

Your social login is now configured and ready to use!
