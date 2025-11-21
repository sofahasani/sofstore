# 🚀 Quick Install - Social Login

## Step 1: Install Socialite Package

```bash
composer require laravel/socialite
```

## Step 2: Run Migration

```bash
php artisan migrate
```

## Step 3: Add to .env file

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback

FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URI=${APP_URL}/auth/facebook/callback

LINKEDIN_CLIENT_ID=your-linkedin-client-id
LINKEDIN_CLIENT_SECRET=your-linkedin-client-secret
LINKEDIN_REDIRECT_URI=${APP_URL}/auth/linkedin/callback
```

## Step 4: Get API Credentials

### Google

https://console.cloud.google.com/
→ Create Project → APIs & Services → Credentials → Create OAuth 2.0 Client ID

### Facebook

https://developers.facebook.com/
→ My Apps → Create App → Add Facebook Login Product

### LinkedIn

https://www.linkedin.com/developers/
→ Create App → Products → Sign In with LinkedIn

## ✅ Done! Social login buttons are now functional!
