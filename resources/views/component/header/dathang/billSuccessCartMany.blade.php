<style>
    /* Center the content and add some spacing */
    .payment-success {
        font-size: 24px;
        font-weight: bold;
        color: #2ecc71;
        /* Green for success */
        text-align: center;
        margin: 50px 0 20px;
        font-family: 'Arial', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Style the home link container */
    .home-link {
        text-align: center;
    }

    /* Style the home link as a button */
    .home-link a {
        display: inline-block;
        padding: 12px 30px;
        background-color: #3498db;
        /* Blue background */
        color: #ffffff;
        /* White text */
        text-decoration: none;
        font-size: 16px;
        font-family: 'Arial', sans-serif;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    /* Hover effect for the button */
    .home-link a:hover {
        background-color: #2980b9;
        /* Darker blue on hover */
        transform: translateY(-2px);
        /* Slight lift effect */
    }

    /* Optional: Add a subtle shadow for depth */
    .home-link a {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="payment-success">Thanh toán thành công</div>
<div class="home-link">
    <a href="{{ route('website-main') }}">Home</a>
</div>
