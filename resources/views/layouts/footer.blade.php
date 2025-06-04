<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .footer {
        background-color: #FFFBEF;
        color: white;
        padding: 40px 20px;

    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-left {
        max-width: 400px;
    }

    .footer-left h2 {
        color: #843902;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .footer-left p {
        color: #843902;
        margin-bottom: 20px;
    }

    .social-icons {
        display: flex;
        gap: 10px;
    }

    .social-icons a {
        background-color: #F2D8A7;
        color: #884F22;
        text-decoration: none;
        padding: 10px;
        border-radius: 10%;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        transition: background-color 0.3s ease;
    }

    .social-icons a:hover {
        background-color: #e1c48c;
    }

    .footer-right img {
        max-width: 250px;
        height: auto;
        border-radius: 5px;
    }

    @media screen and (max-width: 768px) {
        .footer-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-right {
            margin-top: 20px;
        }
    }
</style>

<footer class="footer">
    <div class="footer-container">
        <!-- Left section -->
        <div class="footer-left">
            <h2>Etreese</h2>
            <p>Di sinilah fesyen kontemporer bertemu dengan warisan Nusantara. Setiap karya menceritakan kisah tentang
                kebanggaan budaya dan keanggunan modern.
            </p>
            <div class="social-icons">
                <a href="https://instagram.com/etreese.id"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@etreese.id?_t=ZS-8wvVojtQEK1&_r=1"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>

        <!-- Right section as image -->
        <div class="footer-right">
            <img src="{{ asset('../images/logo.png') }}" alt="Etreese Logo">
        </div>
    </div>
</footer>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">