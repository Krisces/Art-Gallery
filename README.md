# Art Gallery Web Application  

**EECS 447 Final Project**  

## Project Overview  
The Art Gallery web application is a platform designed to facilitate the buying and selling of artwork. Users can create an account, browse available artworks, and manage their buying and selling activities seamlessly.  

The platform integrates PHP, MySQL, and session variables to maintain user information and ensure a smooth user experience. Our website includes the following features:  
- Browsing and searching artworks  
- Adding, deleting, and managing artworks for sellers  
- Buying artworks and managing payments for buyers  
- Seamless user account functionality to switch between Buyer and Seller roles  

Link to project website: [Art Gallery Platform](https://people.eecs.ku.edu/~h232m035/homepage.php)  

---

## Features  

### 1. **Account System**  
- Users can create an account and log in to access the platform.  
- Accounts support both Buyer and Seller roles, allowing seamless switching between roles with the same credentials.  

### 2. **Artworks Page**  
- Displays all available art pieces with details such as name, price, description, seller information, and rating.  
- Automatically identifies artworks owned by the logged-in user and highlights them.  

### 3. **Search Functionality**  
- Enables users to search for specific artworks by name, description, or username.  
- Supports self-searching for logged-in users to view their own artworks.  

### 4. **Seller Functionality**  
- Sellers can add new artworks by providing details such as name, price, stock, description, and image link.  
- Sellers can delete their artworks from the platform.  

### 5. **Buyer Functionality**  
- Buyers can purchase artworks based on availability and account balance.  
- The system handles stock updates, payment processing, and seller ratings after a successful transaction.  

---

## Database Design  

The project uses a MySQL database hosted on KU’s phpMyAdmin. The following tables are used in the database:  

1. **Account**  
   - Account_ID, user_name, pass_word, created_on, linked_account_ID  

2. **Buyer**  
   - Account_ID, shipping_address, last_buy_date, last_bought_item_ID  

3. **Seller**  
   - Account_ID, seller_rating, last_sold_date  

4. **Product**  
   - Product_ID, name, quantity, created_on, last_sold_on, image, description, rating, price, seller_account_ID, last_buyer_account_ID  

5. **Payment_Method**  
   - Payment_Method_ID, balance, opened_on, type, routing_info, linked_account_ID  

---

## Implementation Details  

1. **Session Variables**  
   - Used to manage user sessions and maintain login status across multiple pages.  

2. **PHP and SQL Integration**  
   - Dynamic content rendering based on database queries.  
   - SQL queries handle authentication, product management, purchases, and search functionality.  

3. **Artworks Page**  
   - Implements a `while` loop to fetch and display artworks from the database.  
   - Custom logic to identify artworks owned by the logged-in user.  

4. **Search Function**  
   - Executes SQL queries to filter artworks based on user input.  

5. **Adding and Deleting Items**  
   - Sellers can add new products with input validation.  
   - Products are deleted after verifying their existence in the database.  

6. **Buying Functionality**  
   - Validates stock availability and payment details before processing purchases.  
   - Updates database records for stock, payment balances, and seller ratings.  

---

## Testing  

1. **Homepage**  
   - Allows users to browse the gallery, search for items, or log in to an account.  

2. **Artworks Page**  
   - Displays all available artworks along with their details.  

3. **User Accounts**  
   - Verified seamless switching between Buyer and Seller roles.  

4. **Buying and Selling**  
   - Tested the addition, deletion, and purchase of artworks.  
   - Validated database updates for stock and payment information.  

---

## How to Use  

### Login Credentials for Testing  
Use the following credentials to test the platform:  

| Username   | Password       |  
|------------|----------------|  
| alice123   | alicealice     |  
| charlie345 | charliecharlie |  
| frank678   | frankfrank     |  

### Steps to Test the Application  
1. Navigate to the [Art Gallery Platform](https://people.eecs.ku.edu/~h232m035/homepage.php).  
2. Log in using the provided credentials or create a new account.  
3. Browse the gallery or search for specific artworks.  
4. If logged in as a Seller, add or delete artworks.  
5. If logged in as a Buyer, purchase artworks and view account details.  

