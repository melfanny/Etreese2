<style>
    .home-upcoming-header {
        background-color: #843902;
        color: white;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-weight: bold;
        text-align: center;
        padding: 30px 0;
        font-size: 2rem;
    }

    .home-upcoming-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 50px 10%;
        background-color: #FFFBEF;
        gap: 40px;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .home-upcoming-left {
        flex: 1 1 40%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        color: #843902;
        gap: 20px;
        font-weight: bold;
    }

    .home-upcoming-left h2 {
        font-size: 2rem;
        line-height: 1.3;
    }

    .home-upcoming-left mark {
        background-color: #E6B597;
        color: #843902;
        padding: 0 5px;
    }

    .home-upcoming-left .btn-see {
        background-color: #843902;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 10px;
    }

    .home-upcoming-grid {
        flex: 1 1 55%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }

    .home-upcoming-grid img {
        width: 100%;
        height: auto;
        border-radius: 100%;
        background-color: #EDC2AA;
        padding: 20px;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .home-upcoming-section {
            flex-direction: column;
            align-items: center;
        }

        .home-upcoming-left {
            text-align: center;
            align-items: center;
        }

        .home-upcoming-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }
</style>

<div class="home-upcoming">
    <!-- TOP HEADER -->
    <div class="home-upcoming-header">
        UPCOMING SERIES
    </div>

    <!-- MAIN CONTENT -->
    <section class="home-upcoming-section">
        <div class="home-upcoming-left">
            <h2>
                CURIOUS WHAT WILL<br>
                WE <mark>COMBINE</mark><br>
                IN OUR NEW<br>
                <mark>PRODUCT?</mark>
            </h2>
            <a href="{{ route('products') }}" class="btn-see">See More</a>
        </div>
        <div class="home-upcoming-grid">
            <img src="../images/nasikuning.png" alt="Nasi kuning">
            <img src="../images/buburayam.png" alt="Bubur">
            <img src="../images/nasikuning.png" alt="Bakso">
            <img src="../images/nasikuning.png" alt="Sate">
        </div>
    </section>
</div>