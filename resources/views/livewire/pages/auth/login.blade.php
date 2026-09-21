<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.empty')]
  class extends Component {
  public LoginForm $form;

  /**
   * Handle an incoming authentication request.
   */
  public function login(): void
  {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
  }
}; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Signal — Log in</title>
  <script>
    document.documentElement.classList.add('entry-pending');
    window.__entryFallback = setTimeout(function () {
      document.documentElement.classList.remove('entry-pending');
    }, 3500);
  </script>
  <style>
    @font-face {
      font-family: 'FreeSans';
      font-weight: 400;
      font-style: normal;
      font-display: block;
      src: url('data:font/woff2;base64,d09GMgABAAAAAAQwAA0AAAAACVAAAA3ZAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP0ZGVE0cGh4GYACDYhEQDApYpHgTCAqCYIEKCwABABNgA3QEEAQ4BHYMgQAbzAZ7V4v0d3D+2u6+39z3gXlhU4hL4l/xL4nJbMIGkS5v23P4/y118lW44VdIEq70tV6b+8Q3439Qc5rV+A/w37/v1957ZlYd0QJ0YhN6J/I7eBvepQ2uEw54+yqK+s+2N7dD7d9k5EwL2M3VjXw60YwQzJ675E/k/4H8/92+vX0/J08C99b+D+A/4294G96lDbYT3w043+J+Ewly5gTfHn63a8a3xN+/s42cOfT4QYFwUAK2WlG7Kz4s3f/J/2pYAKgQy+wV9gR0hR0Cggv4s+pZgL8n1w2d0d0R/n6uC5gD2w23E3h/yM3nF2gE0gA3+yF2Q2C9fN4X0G/x/V4B0A7+G4gI6A9073QAd4DuA2XN/m/z/3+S/x/d117W+7xvwbYgvhzVfP80r66e/JvYyq6p4Wn1yV9V5ZlY1qZ++o/7wX+cff+1l+8pTjN/b02mYqg+m9iW4Y+G136/8v41P/J05s/P6+Pq6O9/Z5g9eZq/h515qf765nK4+/5/z/018/j43wMhAAAAA') format('woff2');
    }

    @font-face {
      font-family: 'FreeSans';
      font-weight: 700;
      font-style: normal;
      font-display: block;
      src: url('data:font/woff2;base64,d09GMgABAAAAAAQwAA0AAAAACVAAAA3ZAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP0ZGVE0cGh4GYACDYhEQDApYpHgTCAqCYIEKCwABABNgA3QEEAQ4BHYMgQAbzAZ7V4v0d3D+2u6+39z3gXlhU4hL4l/xL4nJbMIGkS5v23P4/y118lW44VdIEq70tV6b+8Q3439Qc5rV+A/w37/v1957ZlYd0QJ0YhN6J/I7eBvepQ2uEw54+yqK+s+2N7dD7d9k5EwL2M3VjXw60YwQzJ675E/k/4H8/92+vX0/J08C99b+D+A/4294G96lDbYT3w043+J+Ewly5gTfHn63a8a3xN+/s42cOfT4QYFwUAK2WlG7Kz4s3f/J/2pYAKgQy+wV9gR0hR0Cggv4s+pZgL8n1w2d0d0R/n6uC5gD2w23E3h/yM3nF2gE0gA3+yF2Q2C9fN4X0G/x/V4B0A7+G4gI6A9073QAd4DuA2XN/m/z/3+S/x/d117W+7xvwbYgvhzVfP80r66e/JvYyq6p4Wn1yV9V5ZlY1qZ++o/7wX+cff+1l+8pTjN/b02mYqg+m9iW4Y+G136/8v41P/J05s/P6+Pq6O9/Z5g9eZq/h515qf765nK4+/5/z/018/j43wMhAAAAA') format('woff2');
    }

    @font-face {
      font-family: 'Eloquia';
      font-weight: 200 800;
      font-style: normal;
      font-display: block;
      src: url('data:font/woff2;base64,d09GMgABAAAAAAQwAA0AAAAACVAAAA3ZAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP0ZGVE0cGh4GYACDYhEQDApYpHgTCAqCYIEKCwABABNgA3QEEAQ4BHYMgQAbzAZ7V4v0d3D+2u6+39z3gXlhU4hL4l/xL4nJbMIGkS5v23P4/y118lW44VdIEq70tV6b+8Q3439Qc5rV+A/w37/v1957ZlYd0QJ0YhN6J/I7eBvepQ2uEw54+yqK+s+2N7dD7d9k5EwL2M3VjXw60YwQzJ675E/k/4H8/92+vX0/J08C99b+D+A/4294G96lDbYT3w043+J+Ewly5gTfHn63a8a3xN+/s42cOfT4QYFwUAK2WlG7Kz4s3f/J/2pYAKgQy+wV9gR0hR0Cggv4s+pZgL8n1w2d0d0R/n6uC5gD2w23E3h/yM3nF2gE0gA3+yF2Q2C9fN4X0G/x/V4B0A7+G4gI6A9073QAd4DuA2XN/m/z/3+S/x/d117W+7xvwbYgvhzVfP80r66e/JvYyq6p4Wn1yV9V5ZlY1qZ++o/7wX+cff+1l+8pTjN/b02mYqg+m9iW4Y+G136/8v41P/J05s/P6+Pq6O9/Z5g9eZq/h515qf765nK4+/5/z/018/j43wMhAAAAA') format('woff2-variations');
    }

    :root {
      --W: 1464;
      --H: 949;
      --photoW: 836;
      --paneW: 628;
      --cardW: 613;
      --cardH: 922;

      --badge-fs: 13.60px;
      --badge-fw: 400;
      --badge-ls: -0.163px;
      --badge-gap: 10px;
      --badge-dy: 0px;
      --badge-ws: 0px;
      --badge-left: 34px;
      --badge-top: 684px;
      --hl-lh: 1;
      --hl-wght: 578;
      --hl1-fs: 69.14px;
      --hl1-ls: -1.936px;
      --hl1-ws: 0px;
      --hl1-left: 33.00px;
      --hl1-top: 750.02px;
      --hl2-fs: 68.95px;
      --hl2-ls: -1.931px;
      --hl2-left: 32.00px;
      --hl2-top: 831.01px;
      --h1-top: 65.00px;
      --h1-fs: 42.55px;
      --h1-ls: -2.553px;
      --h1-ws: 1.300px;
      --h1-wght: 584;
      --sub-top: 120.00px;
      --sub-fs: 20.41px;
      --sub-ls: -0.245px;
      --sub-ws: -2.000px;
      --sub-fw: 400;
      --sub-fwb: 700;
      --fieldpad: 19px;
      --eph-fs: 15.68px;
      --eph-ls: -0.188px;
      --eph-left: 17.0px;
      --eph-fw: 400;
      --eph-ws: 0px;
      --pph-fs: 17.29px;
      --pph-ls: -0.698px;
      --pph-left: 18px;
      --pph-fw: 400;
      --login-fs: 16.38px;
      --login-fw: 400;
      --login-ls: 0.200px;
      --login-gap: 10px;
      --login-dy: 0.00px;
      --login-padl: -12.00px;
      --arrow-w: 13.2px;
      --div-top: 477px;
      --or-fs: 11.5px;
      --or-fw: 700;
      --or-ls: 0.8px;
      --or-dy: 2.00px;
      --or-dx: 0.00px;
      --or-line-l: 205px;
      --or-line-r: 204px;
      --g-gap: 17px;
      --g-icon: 18.5px;
      --gt-fs: 18.10px;
      --gt-fw: 400;
      --gt-ls: -0.217px;
      --gt-ws: -1.000px;
      --gt-dy: 1.00px;
      --bt-top: 611.00px;
      --bt-fs: 16.37px;
      --bt-fw: 400;
      --bt-ls: -0.196px;
      --bt-ws: -2.060px;
      --bt-fwb: 700;
      --bt-uo: 3px;
      --card-shadow: 1px 10px 14px rgba(10, 14, 20, 0.14), 0 1px 3px rgba(10, 14, 20, 0.05);
      --cs: 1;

      --ink: #000;
      --h1-color: #2c3343;
      --sub-grey: #797979;
      --badge-bg: #2f2a27;
      --ph: #606060;
      --or: #5a5a5b;
      --gtext: #232424;
      --bottom: #0a0a0a;
      --btn1: #283139;
      --btn2: #293340;
      --inputFill: #fafafa;
      --inputBorder: #acacae;
      --pwFill: #f9f9f9;
      --gBorder: #c8c8ca;
      --divider: #b1b1b2;
      --page: #fefefe;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      background: var(--page);
      font-family: 'FreeSans', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      text-rendering: geometricPrecision;
      overflow: hidden;
    }

    .stage {
      position: fixed;
      inset: 0;
      overflow: hidden;
    }

    .photo {
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 57.1038%;
      overflow: hidden;
    }

    .photo-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: 100% 50%;
      display: block;
      -webkit-user-drag: none;
    }

    .photo-img--wide {
      display: none;
    }

    .scrim {
      display: none;
    }

    .hero {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 836px;
      height: 949px;
      transform-origin: left bottom;
      pointer-events: none;
    }

    .hero>* {
      pointer-events: auto;
    }

    .badge {
      position: absolute;
      left: var(--badge-left);
      top: var(--badge-top);
      display: inline-flex;
      align-items: center;
      height: 37px;
      padding: 0 16px 0 19px;
      border-radius: 999px;
      background: var(--badge-bg);
      backdrop-filter: blur(7px) saturate(120%);
      -webkit-backdrop-filter: blur(7px) saturate(120%);
      box-shadow: 0 1px 2px rgba(0, 0, 0, .18), 0 6px 18px rgba(0, 0, 0, .14);
      color: #fff;
      font-size: var(--badge-fs);
      font-weight: var(--badge-fw);
      letter-spacing: var(--badge-ls);
      white-space: nowrap;
      gap: var(--badge-gap);
    }

    .badge-glyph {
      width: 17px;
      height: 16.27px;
      position: relative;
      top: -1px;
      fill: #fff;
      flex-shrink: 0;
    }

    .hl {
      position: absolute;
      font-family: 'Eloquia', 'FreeSans', sans-serif;
      font-variation-settings: 'wght' var(--hl-wght);
      font-weight: 700;
      line-height: var(--hl-lh);
      color: var(--ink);
      white-space: nowrap;
    }

    #hl1 {
      left: var(--hl1-left);
      top: var(--hl1-top);
      font-size: var(--hl1-fs);
      letter-spacing: var(--hl1-ls);
    }

    #hl2 {
      left: var(--hl2-left);
      top: var(--hl2-top);
      font-size: var(--hl2-fs);
      letter-spacing: var(--hl2-ls);
    }

    .pane {
      position: absolute;
      left: 57.1038%;
      right: 0;
      top: 0;
      bottom: 0;
    }

    .card {
      position: absolute;
      left: 1px;
      top: 14px;
      width: 613px;
      height: 922px;
      border-radius: 26px;
      overflow: hidden;
      background: rgba(254, 254, 254, .90);
      backdrop-filter: blur(28px) saturate(160%);
      -webkit-backdrop-filter: blur(28px) saturate(160%);
      border: 1px solid rgba(0, 0, 0, .036);
      box-shadow: var(--card-shadow);
    }

    .card-in {
      width: 613px;
      height: 922px;
      position: absolute;
      left: 0;
      top: 0;
      transform-origin: left top;
    }

    .col {
      position: absolute;
      left: 62px;
      width: 488px;
    }

    .field {
      position: absolute;
      left: 62px;
      width: 489px;
      display: flex;
      align-items: center;
      border-radius: 12px;
    }

    .field input {
      width: 100%;
      height: 100%;
      background: transparent;
      border: 0;
      outline: 0;
      padding-left: var(--fieldpad);
      padding-right: var(--fieldpad);
      font-family: inherit;
      color: var(--ink);
    }

    #email {
      top: 203px;
      height: 61px;
      background: var(--inputFill);
      border: 1.5px solid var(--inputBorder);
    }

    #email input {
      font-size: var(--eph-fs);
      letter-spacing: var(--eph-ls);
      font-weight: var(--eph-fw);
    }

    #email input::placeholder {
      color: var(--ph);
      opacity: 1;
    }

    #pw {
      top: 273.5px;
      height: 59px;
      background: var(--pwFill);
      border: 0;
    }

    #pw input {
      font-size: var(--pph-fs);
      letter-spacing: var(--pph-ls);
      font-weight: var(--pph-fw);
    }

    #pw input::placeholder {
      color: var(--ph);
      opacity: 1;
    }

    #h1 {
      top: var(--h1-top);
      font-family: 'Eloquia', 'FreeSans', sans-serif;
      font-variation-settings: 'wght' var(--h1-wght);
      font-weight: 700;
      font-size: var(--h1-fs);
      letter-spacing: var(--h1-ls);
      word-spacing: var(--h1-ws);
      color: var(--h1-color);
      margin: 0;
      text-align: center;
    }

    #sub {
      top: var(--sub-top);
      font-size: var(--sub-fs);
      letter-spacing: var(--sub-ls);
      word-spacing: var(--sub-ws);
      font-weight: var(--sub-fw);
      color: var(--sub-grey);
      margin: 0;
      text-align: center;
    }

    #sub b {
      font-weight: var(--sub-fwb);
      color: var(--ink);
    }

    #loginBtn {
      position: absolute;
      left: 62px;
      top: 366px;
      width: 489px;
      height: 65.5px;
      border-radius: 999px;
      background: #39e554;
      color: #0f172a;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--login-gap);
      padding-left: var(--login-padl);
      padding-right: 4px;
      box-shadow: 0 8px 20px rgba(18, 26, 34, .16), 0 2px 5px rgba(18, 26, 34, .10);
      border: 0;
      cursor: pointer;
      font-size: var(--login-fs);
      font-weight: var(--login-fw);
      letter-spacing: var(--login-ls);
      font-family: inherit;
      transition: transform .18s cubic-bezier(.2, .7, .3, 1), box-shadow .18s ease, filter .18s ease;
    }

    #loginBtn:hover {
      filter: brightness(1.12);
    }

    #loginBtn:active {
      transform: translateY(1px);
    }

    .login-arrow {
      width: var(--arrow-w);
      height: auto;
      flex-shrink: 0;
    }

    .divider {
      position: absolute;
      left: 63px;
      top: var(--div-top);
      width: 487px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--or);
      font-size: var(--or-fs);
      font-weight: var(--or-fw);
      letter-spacing: var(--or-ls);
    }

    .divider i {
      height: 1.5px;
      background: var(--divider);
      font-style: normal;
    }

    .divider i:first-child {
      flex: 0 0 var(--or-line-l);
    }

    .divider i:last-child {
      flex: 0 0 var(--or-line-r);
    }

    .divider b {
      flex: 1 1 auto;
      text-align: center;
      font-weight: var(--or-fw);
      transform: translate(var(--or-dx), var(--or-dy));
    }

    #gBtn {
      position: absolute;
      left: 62px;
      top: 535px;
      width: 489px;
      height: 59.5px;
      border: 1.5px solid var(--gBorder);
      border-radius: 999px;
      background: rgba(255, 255, 255, .92);
      box-shadow: 0 1px 2px rgba(0, 0, 0, .03);
      color: var(--gtext);
      font-size: var(--gt-fs);
      font-weight: var(--gt-fw);
      letter-spacing: var(--gt-ls);
      word-spacing: var(--gt-ws);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--g-gap);
      font-family: inherit;
      cursor: pointer;
      transition: background .18s ease, box-shadow .18s ease, transform .18s cubic-bezier(.2, .7, .3, 1);
    }

    #gBtn:hover {
      background: #fff;
      box-shadow: 0 3px 10px rgba(0, 0, 0, .07);
    }

    #gBtn:active {
      transform: translateY(1px);
    }

    .g-icon {
      width: var(--g-icon);
      height: var(--g-icon);
      flex-shrink: 0;
    }

    #bottom {
      position: absolute;
      left: 62px;
      width: 489px;
      top: var(--bt-top);
      text-align: center;
      font-size: var(--bt-fs);
      font-weight: var(--bt-fw);
      letter-spacing: var(--bt-ls);
      word-spacing: var(--bt-ws);
      color: var(--bottom);
      margin: 0;
    }

    #bottom a {
      color: #000;
      font-weight: var(--bt-fwb);
      text-decoration: underline;
      text-underline-offset: var(--bt-uo);
      text-decoration-thickness: 2px;
    }

    :focus-visible {
      outline: 2px solid #2b6cb0;
      outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
      * {
        transition: none !important;
        animation: none !important;
      }
    }

    /* Mode B — Tablet Portrait */
    body.tabport {
      overflow-y: auto;
    }

    body.tabport .stage {
      position: relative;
      height: auto;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    body.tabport .photo {
      position: relative;
      left: 0;
      top: 0;
      width: 100%;
      height: var(--tp-band-h, 400px);
    }

    body.tabport .photo-img--tall {
      display: none;
    }

    body.tabport .photo-img--wide {
      display: block;
      object-position: 50% 50%;
    }

    body.tabport .hero {
      position: absolute;
      left: var(--tp-side, 40px);
      bottom: var(--tp-hero-b, 30px);
      width: auto;
      height: auto;
      transform: none !important;
      display: flex;
      flex-direction: column;
      gap: var(--tp-hero-gap, -20px);
    }

    body.tabport .badge {
      position: relative;
      left: 0;
      top: 0;
      transform: scale(var(--badge-k, 1));
      transform-origin: left bottom;
    }

    body.tabport .hl-wrap {
      position: relative;
    }

    body.tabport .hl {
      position: relative;
      left: 0;
      top: 0;
      display: inline;
      font-size: var(--tp-hero-fs, 48px);
      line-height: 1.1246;
    }

    body.tabport .pane {
      position: relative;
      left: 0;
      width: 100%;
      flex: 1;
    }

    body.tabport .card {
      position: relative;
      left: var(--tp-side, 40px);
      top: 0;
      width: calc(100% - (var(--tp-side, 40px) * 2));
      height: auto;
      min-height: 400px;
      border-radius: 24px;
    }

    body.tabport .card-in {
      position: relative;
      inset: 0;
      width: 100%;
      height: auto;
      transform: none !important;
      padding: var(--tp-pad, 40px);
    }

    /* Mode C — Phone (<700px) */
    body.stacked {
      height: auto;
      min-height: 100%;
      overflow-y: auto;
      background: #fff;
    }

    body.stacked .stage {
      position: relative;
      display: flex;
      flex-direction: column;
      min-height: 100svh;
    }

    body.stacked .photo {
      position: relative;
      left: 0;
      top: 0;
      width: 100%;
      height: var(--mobile-hero-h, clamp(244px, 34svh, 304px));
    }

    body.stacked .photo-img--tall {
      display: none;
    }

    body.stacked .photo-img--wide {
      display: block;
      object-position: 64% 48%;
      transform: scale(1.015);
    }

    body.stacked .scrim {
      display: block;
      position: absolute;
      inset: 0;
      pointer-events: none;
      background: linear-gradient(180deg, rgba(7, 10, 13, .02) 18%, rgba(7, 10, 13, .12) 48%, rgba(7, 10, 13, .78) 100%);
    }

    body.stacked .hero {
      position: absolute;
      left: 20px;
      bottom: 38px;
      width: calc(100% - 40px);
      height: auto;
      transform: none !important;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    body.stacked .badge {
      position: relative;
      left: 0;
      top: 0;
      height: 31px;
      padding: 0 12px;
      background: rgba(24, 27, 30, .82);
      box-shadow: 0 4px 16px rgba(0, 0, 0, .18);
      font-size: 11px;
    }

    body.stacked .hl-wrap {
      position: relative;
      display: flex;
      flex-direction: column;
    }

    body.stacked .hl {
      position: relative;
      left: 0;
      top: 0;
      color: #fff;
      font-size: clamp(30px, 8.8vw, 38px);
      letter-spacing: -.035em;
      line-height: .96;
      text-shadow: 0 2px 18px rgba(0, 0, 0, .32);
    }

    body.stacked .pane {
      position: relative;
      left: 0;
      width: 100%;
      flex: 1;
    }

    body.stacked .card {
      position: relative;
      left: 0;
      top: 0;
      width: 100%;
      margin: -28px 0 0;
      border-radius: 28px 28px 0 0;
      background: #fff;
      border: 0;
      box-shadow: 0 -10px 28px rgba(20, 28, 36, .10);
      min-height: calc(100svh - var(--mobile-hero-h, 280px) + 28px);
    }

    body.stacked .card-in {
      position: relative;
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      padding: 36px clamp(24px, 7vw, 38px) max(30px, env(safe-area-inset-bottom));
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: auto;
      transform: none !important;
    }

    body.stacked .col,
    body.stacked .field,
    body.stacked #loginBtn,
    body.stacked .divider,
    body.stacked #gBtn,
    body.stacked #bottom {
      position: static;
      width: 100%;
      left: auto;
      top: auto;
    }

    body.stacked #h1 {
      font-size: clamp(31px, 8.8vw, 38px);
      margin-bottom: 8px;
    }

    body.stacked #sub {
      font-size: 15px;
      margin-bottom: 24px;
    }

    body.stacked .field {
      height: 56px;
      margin-bottom: 14px;
    }

    body.stacked .field input {
      font-size: 16px;
    }

    body.stacked #loginBtn {
      height: 58px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    body.stacked .divider {
      margin-bottom: 20px;
    }

    body.stacked #gBtn {
      height: 56px;
      margin-bottom: 24px;
    }

    body.stacked #bottom {
      font-size: 14px;
    }

    @media (max-width: 370px) {
      body.stacked .photo {
        height: 232px;
      }

      body.stacked .hl {
        font-size: 30px;
      }
    }

    @media (max-height: 520px) and (orientation: landscape) {
      body.stacked .photo {
        height: 208px;
      }

      body.stacked .card-in {
        justify-content: flex-start;
      }
    }

    /* Entrance Animation First-Frame Guard */
    .entry-pending .card,
    .entry-pending .badge,
    .entry-pending #hl1,
    .entry-pending #hl2,
    .entry-pending #h1,
    .entry-pending #sub,
    .entry-pending #email,
    .entry-pending #pw,
    .entry-pending #loginBtn,
    .entry-pending .divider,
    .entry-pending #gBtn,
    .entry-pending #bottom {
      opacity: 0;
      will-change: transform, opacity, clip-path;
    }

    .entry-pending .card {
      transform: translateY(12px) scale(.988);
    }

    @media (max-width: 699px) {
      .entry-pending .card {
        transform: translateY(14px);
      }
    }

    .entry-pending .badge {
      transform: translateY(8px);
    }

    .entry-pending #hl1,
    .entry-pending #hl2 {
      transform: translateY(16px);
      clip-path: inset(100% 0 0 0);
    }

    @media (max-width: 699px) {

      .entry-pending #hl1,
      .entry-pending #hl2 {
        transform: translateY(12px);
      }
    }

    .entry-pending #h1,
    .entry-pending #sub {
      transform: translateY(10px);
    }

    .entry-pending #email,
    .entry-pending #pw,
    .entry-pending #loginBtn,
    .entry-pending #gBtn {
      transform: translateY(8px);
    }

    .entry-pending .divider,
    .entry-pending #bottom {
      transform: translateY(6px);
    }

    @media (prefers-reduced-motion: reduce) {

      .entry-pending .card,
      .entry-pending .badge,
      .entry-pending #hl1,
      .entry-pending #hl2,
      .entry-pending #h1,
      .entry-pending #sub,
      .entry-pending #email,
      .entry-pending #pw,
      .entry-pending #loginBtn,
      .entry-pending .divider,
      .entry-pending #gBtn,
      .entry-pending #bottom {
        opacity: 1 !important;
        transform: none !important;
        clip-path: none !important;
        will-change: auto !important;
      }
    }
  </style>
</head>

<body>

  <form wire:submit="login" class="stage">
    <section class="photo">
      <img class="photo-img photo-img--tall" src="{{ asset('five.jpeg') }}" alt="Login Artwork">
      <img class="photo-img photo-img--wide" aria-hidden="true" src="{{ asset('login.png') }}" alt="">
      <div class="scrim"></div>
      <div class="hero" id="hero">



      </div>
    </section>
    <section class="pane">
      <div class="card" id="card">
        <div class="card-in" id="cardIn">
          <h1 class="col center" id="h1">Welcome Back!</h1>
          <p class="col center" id="sub"><b>Log in</b> to continue monitoring your signals.</p>
          <div class="field" id="email">
            <input wire:model="form.email" type="email" autocomplete="email" aria-label="Email address"
              placeholder="Eg. johndoe@gmail.com" required autofocus>
          </div>
          <div class="field" id="pw">
            <input wire:model="form.password" type="password" autocomplete="current-password" aria-label="Password"
              placeholder="Password" required>
          </div>
          <button type="submit" id="loginBtn">
            <span>Login</span>
            <svg class="login-arrow" viewBox="0 0 22 22" aria-hidden="true">
              <path d="M3 11h15.4M11 3.3l7.7 7.7-7.7 7.7" stroke="#fff" stroke-width="2.6" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </button>
          <div class="divider">
            <i></i><b>OR</b><i></i>
          </div>
          <button type="button" id="gBtn">
            <svg class="g-icon" viewBox="0 0 48 48" aria-hidden="true">
              <path fill="#EA4335"
                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.66 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
              <path fill="#4285F4"
                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
              <path fill="#FBBC05"
                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.28-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
              <path fill="#34A853"
                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.66 48 24 48z" />
            </svg>
            <span>Sign in with Google</span>
          </button>
          <p id="bottom">Don&#8217;t have an account? <a href="{{ route('register') }}">Start Free</a></p>
        </div>
      </div>
    </section>
  </form>

  <script>
    (function () {
      var REF_W = 1464, REF_H = 949, PHOTO_W = 836, PANE_W = 628, CARD_W = 613, CARD_H = 922;
      var CONTENT_H = 697;
      var IMG_W = 1177, IMG_H = 1336, IMG_REF_SCALE = 836 / 1177;
      var PANE_RATIO = PANE_W / REF_W;
      var HERO_W = 681, HERO_H = 219;
      var REF_CARD_ASPECT = 692 / 855;
      var RAMP_HI = 1280, RAMP_LO = 1000, PHOTO_MIN = 0.42;
      var RAMP_LO2 = 820, PHOTO_MIN2 = 0.36;
      var TP = {
        "pad": 0.1076, "h1Top": 0.08656, "h1Fs": 0.06839, "subTop": 0.17368, "subFs": 0.0309,
        "emTop": 0.25435, "emH": 0.10257, "emR": 0.0202, "ephFs": 0.02702, "ephPad": 0.0332,
        "pwTop": 0.36851, "pwH": 0.10839, "btnTop": 0.50435, "btnH": 0.10981, "btnFs": 0.0275,
        "arrow": 0.026, "btnGap": 0.02, "divTop": 0.68222, "orFs": 0.02245, "orPad": 0.051,
        "divH": 0.0026, "gTop": 0.76445, "gH": 0.09966, "gIcon": 0.032, "gtFs": 0.03205,
        "gGap": 0.026, "btTop": 0.89668, "btFs": 0.02876, "heroFs": 0.1058, "badgeH": 0.0742,
        "heroLh": 1.1246, "heroBot": 0.06493, "heroGap": -0.30423, "heroSide": 0.0525
      };

      var photoEl = document.querySelector('.photo');
      var paneEl = document.querySelector('.pane');
      var cardEl = document.getElementById('card');
      var cardInEl = document.getElementById('cardIn');
      var heroEl = document.getElementById('hero');

      var mqLandscape = window.matchMedia('(min-width:700px) and (min-aspect-ratio:51/50)');
      var mqPortrait = window.matchMedia('(min-width:700px) and (max-aspect-ratio:51/50)');

      function clearInline() {
        [photoEl, paneEl, cardEl, cardInEl, heroEl].forEach(function (el) {
          if (el) el.style.cssText = '';
        });
      }

      function photoRatio(vw) {
        if (vw >= RAMP_HI) return 1 - PANE_RATIO;
        if (vw >= RAMP_LO) return PHOTO_MIN + ((1 - PANE_RATIO) - PHOTO_MIN) * ((vw - RAMP_LO) / (RAMP_HI - RAMP_LO));
        if (vw >= RAMP_LO2) return PHOTO_MIN2 + (PHOTO_MIN - PHOTO_MIN2) * ((vw - RAMP_LO2) / (RAMP_LO - RAMP_LO2));
        return PHOTO_MIN2;
      }

      function placeCard(paneW, vh) {
        var cs = Math.min(paneW / PANE_W, vh / CONTENT_H);
        var gapL = 1 * cs, mT = 14 * cs, mB = 13 * cs, mR = 14 * cs;
        var cw = Math.max(CARD_W * cs, paneW - gapL - mR);
        var ch = vh - mT - mB;

        cardEl.style.left = gapL + 'px';
        cardEl.style.top = mT + 'px';
        cardEl.style.width = cw + 'px';
        cardEl.style.height = ch + 'px';
        cardEl.style.borderRadius = (26 * cs) + 'px';
        cardEl.style.borderWidth = Math.max(1, cs) + 'px';

        cardInEl.style.transform = 'translate(' + ((cw - CARD_W * cs) / 2) + 'px,0) scale(' + cs + ')';
      }

      function seatHero(photoW, vh) {
        var imgScale = Math.max(photoW / IMG_W, vh / IMG_H);
        var s = Math.min(imgScale / IMG_REF_SCALE, (photoW * 0.92) / HERO_W);
        heroEl.style.transform = 'scale(' + s + ')';
        heroEl.style.transformOrigin = 'left bottom';
        heroEl.style.bottom = '0px';
        heroEl.style.left = '0px';
      }

      function headlineMeasure() {
        var dummy = document.createElement('span');
        dummy.style.cssText = 'position:absolute;visibility:hidden;white-space:nowrap;font-family:Eloquia,FreeSans,sans-serif;font-variation-settings:"wght" 578;font-size:69px;letter-spacing:-1.9px;';
        document.body.appendChild(dummy);
        var w = dummy.getBoundingClientRect().width;
        document.body.removeChild(dummy);
        return w || 600;
      }

      function layout() {
        var vw = window.innerWidth;
        var vh = window.innerHeight;

        clearInline();
        document.body.classList.remove('tabport', 'stacked');

        if (vw < 700) {
          document.body.classList.add('stacked');
          return;
        }

        if (mqPortrait.matches) {
          document.body.classList.add('tabport');
          var band = Math.round(vh * 0.425);
          var side = Math.round(vw * TP.heroSide);
          var badgeK = (band * TP.badgeH) / 37;
          var hlMeasure = Math.round(headlineMeasure() * 0.61);

          cardEl.style.setProperty('--tp-band-h', band + 'px');
          cardEl.style.setProperty('--tp-side', side + 'px');
          cardEl.style.setProperty('--badge-k', badgeK);
          cardEl.style.setProperty('--tp-hero-b', (band * TP.heroBot) + 'px');
          cardEl.style.setProperty('--tp-hero-gap', (band * TP.heroGap) + 'px');
          cardEl.style.setProperty('--tp-hero-fs', (band * TP.heroFs) + 'px');

          var hlWrap = document.querySelector('.hl-wrap');
          if (hlWrap) hlWrap.style.width = hlMeasure + 'px';

          return;
        }

        // Mode A — Landscape / Desktop
        var pRatio = photoRatio(vw);
        var photoW = vw * pRatio;
        var paneW = vw - photoW;

        photoEl.style.width = photoW + 'px';
        paneEl.style.left = photoW + 'px';
        paneEl.style.width = paneW + 'px';

        placeCard(paneW, vh);
        seatHero(photoW, vh);
      }

      window.addEventListener('resize', layout, { passive: true });
      window.addEventListener('orientationchange', layout);
      if (mqLandscape.addEventListener) {
        mqLandscape.addEventListener('change', layout);
        mqPortrait.addEventListener('change', layout);
      }
      if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(layout);
      }

      layout();
    })();
  </script>

  <script>
    (function () {
      function releaseEntrance() {
        document.documentElement.classList.remove('entry-pending');
        if (window.__entryFallback) clearTimeout(window.__entryFallback);
      }

      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !Element.prototype.animate) {
        releaseEntrance();
        return;
      }

      function startEntrance() {
        var ease = 'cubic-bezier(.16,1,.3,1)';
        var softEase = 'cubic-bezier(.22,1,.36,1)';
        var compact = window.matchMedia('(max-width:699px)').matches;

        var targets = [
          { sel: '#card', delay: 40, dur: 820, ease: ease, from: { opacity: 0, transform: compact ? 'translateY(14px)' : 'translateY(12px) scale(.988)' } },
          { sel: '.badge', delay: 120, dur: 480, ease: softEase, from: { opacity: 0, transform: 'translateY(8px)' } },
          { sel: '#hl1', delay: 240, dur: 760, ease: ease, from: { opacity: 0, transform: compact ? 'translateY(12px)' : 'translateY(16px)', clipPath: 'inset(100% 0 0 0)' } },
          { sel: '#hl2', delay: 330, dur: 760, ease: ease, from: { opacity: 0, transform: compact ? 'translateY(12px)' : 'translateY(16px)', clipPath: 'inset(100% 0 0 0)' } },
          { sel: '#h1', delay: 470, dur: 620, ease: ease, from: { opacity: 0, transform: 'translateY(10px)' } },
          { sel: '#sub', delay: 570, dur: 560, ease: ease, from: { opacity: 0, transform: 'translateY(10px)' } },
          { sel: '#email', delay: 720, dur: 520, ease: softEase, from: { opacity: 0, transform: 'translateY(8px)' } },
          { sel: '#pw', delay: 790, dur: 520, ease: softEase, from: { opacity: 0, transform: 'translateY(8px)' } },
          { sel: '#loginBtn', delay: 930, dur: 560, ease: ease, from: { opacity: 0, transform: 'translateY(8px)' } },
          { sel: '.divider', delay: 1060, dur: 440, ease: softEase, from: { opacity: 0, transform: 'translateY(6px)' } },
          { sel: '#gBtn', delay: 1150, dur: 540, ease: ease, from: { opacity: 0, transform: 'translateY(8px)' } },
          { sel: '#bottom', delay: 1260, dur: 500, ease: softEase, from: { opacity: 0, transform: 'translateY(6px)' } }
        ];

        var anims = [];

        targets.forEach(function (item) {
          var el = document.querySelector(item.sel);
          if (!el) return;
          var toState = { opacity: 1, transform: 'none' };
          if (item.sel === '#hl1' || item.sel === '#hl2') {
            toState.clipPath = 'inset(0 0 0 0)';
          }
          var a = el.animate([item.from, toState], {
            delay: item.delay,
            duration: item.dur,
            easing: item.ease,
            fill: 'both'
          });
          anims.push(a);
        });

        releaseEntrance();

        Promise.allSettled(anims.map(function (a) { return a.finished; })).then(function () {
          anims.forEach(function (a) { a.cancel(); });
          anims = [];
        });
      }

      var fontPromise = (document.fonts && document.fonts.ready) ? document.fonts.ready : Promise.resolve();
      Promise.race([
        fontPromise,
        new Promise(function (r) { setTimeout(r, 650); })
      ]).then(function () {
        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            startEntrance();
          });
        });
      });
    })();
  </script>

</body>

</html>