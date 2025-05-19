<style>
    .home-banner {
        background-color: #EBC4AE;
        padding: 60px 10%;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        color: #843902;
        display: flex;
        justify-content: center;
    }

    .home-banner .image-container {
        position: relative;
        width: 100%;
        max-width: 1200px;
        border-radius: 20px;
        overflow: hidden;
        height: 500px;
    }

    .home-banner .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .home-banner .text-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #843902;
        text-align: center;
        font-weight: 700;
        line-height: 1.2;
        width: 100%;
        padding: 0 20px;
    }

    .home-banner .text-overlay {
        position: absolute;
        top: 50%;
        left: 30px;

        transform: translateY(-50%);
        color: white;
        text-align: left;

        font-weight: 700;
        line-height: 1.2;
        max-width: 60%;

        padding: 0 20px;
    }

    .home-banner .text-overlay .highlight {
        background-color: #EBC4AE;
        padding: 0 8px;
        border-radius: 8px;
        color: white;
        font-size: 48px;
        font-weight: 800;
    }

    .home-banner .text-overlay h1 {
        margin: 0;
        font-size: 48px;
        color: white;
    }


    .home-banner .btn-view {
        position: relative;
        margin-top: 20px;
        background-color: #843902;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
    }

    .home-banner .btn-view:hover {
        background-color: #5C1E00;
    }

    @media (max-width: 768px) {
        .home-banner {
            padding: 40px 5%;
        }

        .home-banner .image-container {
            height: 350px;
        }

        .home-banner .text-overlay h1 {
            font-size: 32px;
        }

        .home-banner .text-overlay .highlight {
            font-size: 32px;
        }
    }
</style>

<div class="home-banner">
    <div class="image-container">
        <img src="https://i.pinimg.com/736x/06/99/ab/0699ab50f9da314b9fd6d09d83814694.jpg" alt="Bloom Series" />
        <div class="text-overlay">
            <h1>
                <span class="highlight">BLOOM SERIES</span><br>
                BOOST YOUR<br>CONFIDENCE
            </h1>
            <a href="{{ route('products') }}" class="btn-view">View all product</a>
        </div>
    </div>
</div>