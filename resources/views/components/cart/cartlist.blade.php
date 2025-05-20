<style>
    .cart-section {
        background-color: #EBC4AE;
        padding: 50px 20px;
        font-family: sans-serif;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 50px; /* biar center */
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        flex-wrap: wrap;
        max-width: 1800px;  /* Supaya gak mentok kiri kanan */
        min-height: 200px;  /* Supaya terlihat "tinggi" */
    }


    .cart-item-left {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }

    .cart-item-left img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
    }

    .cart-item-left h3 {
        font-size: 16px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .cart-item-left p {
        color: #843902;
        font-weight: bold;
        margin: 0;
    }

    .qty-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-buttons button {
        width: 30px;
        height: 30px;
        border: 1px solid #ccc;
        background-color: white;
        font-weight: bold;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
    }

    .qty-buttons span {
        font-size: 16px;
        font-weight: bold;
    }

    .cart-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 50px; /* biar center */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    flex-wrap: wrap;
    max-width: 1800px;  /* Supaya gak mentok kiri kanan */
    
    }

    .cart-footer-left {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .cart-footer button,
    .cart-footer a {
        background-color: #843902;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 15px;
        font-weight: bold;
        transition: background-color 0.2s;
        border: none;
        cursor: pointer;
    }

    .cart-footer a:hover,
    .cart-footer button:hover {
        background-color: #843902;
    }

    .cart-footer span {
        font-size: 18px;
        font-weight: bold;
        margin-right: 10px;
    }

    .remove-button {
    display: flex;
    align-items: center;
    gap: 10px;
    background-color: white;
    border: none;
    font-size: 18px;
    font-weight: bold;
    color: black;
    cursor: pointer;
}

.remove-button img {
    width: 25px;
    height: 25px;
}
    @media (max-width: 600px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .qty-buttons {
            margin-top: 10px;
        }

        .cart-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="cart-section">
    <!-- Item 1 -->
    <div class="cart-item">
        <div class="cart-item-left">
            <input type="checkbox">
            <img src="{{ asset('images/kemejahitam.jpg') }}" alt="Kemeja 1">
            <div>
                <h3>Etreese - Blooming Serenity Kemeja Semi Formal Elegan</h3>
                <p>Rp150.000</p>
            </div>
        </div>
        <div class="qty-buttons">
            <button>-</button>
            <span>3</span>
            <button>+</button>
        </div>
    </div>

    <!-- Item 2 -->
    <div class="cart-item">
        <div class="cart-item-left">
            <input type="checkbox">
            <img src="{{ asset('images/kemejaputih.jpg') }}" alt="Kemeja 2">
            <div>
                <h3>Etreese - Ethereal Bloom Kemeja Semi Formal Elegan</h3>
                <p>Rp150.000</p>
            </div>
        </div>
        <div class="qty-buttons">
            <button>-</button>
            <span>1</span>
            <button>+</button>
        </div>
    </div>

    <!-- Footer -->
    <div class="cart-footer">
        <div class="cart-footer-left">
            <input type="checkbox"> <label>All Product</label>
            <button class="remove-button">
            <img src="{{ asset('images/trashlogo.png') }}" alt="Trash Icon">
            <span>Remove</span>
        </button>
        </div>
        <div>
            <span>Total: Rp300.000</span>
            <a href="#">Checkout (2)</a>
        </div>
    </div>
</div>
