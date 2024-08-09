Για την υλοποίηση έχω επιλέξει να χρησιμοποιήσω την τελευταία έκδοση του Laravel (v. 11) και  το sail για να φτιάξω το περιβάλλον εργασίας. Για να μπορέσετε να το τρέξετε θα πρέπει να έχετε εγκατεστημένο στον υπολογιστή σας το docker.

Οδηγίες:

	composer install
	./vendor/bin/sail up -d
	./vendor/bin/sail bash
	php artisan migrate –path=database/migrations/landlord –database=landlord –seed

Προσέγγιση:

Για την επίτευξη της λειτουργικότητας Multi-tenancy χρησιμοποίησα το spatie.
Για την αρχιτεκτονική αποφάσισα να το χωρίσω στις 2 κυρίως οντότητες της εφαρμογής μας, α) User,  β) Project

Η δομή είναι η εξής:

/App
<ul> 
    <li> User 
    <ul> 
        <li> Controllers </li>
        <li> Repositories </li>
        <li> Services </li>
        <li> Resources </li>
        <li> Validators </li>
    </ul>
    <li> Project 
    <ul>
        <li> Controllers </li>
        <li> Repositories </li>
        <li> Services </li>
        <li> Resources </li>
        <li> Validators </li>
    </ul>
    </li>
</ul>


Για το τεστ χρησιμοποίησα το Pest σε συνδυασμό με mockery

Για να τρέξετε τα τεστ εκτελέστε την παρακάτω εντολή:

php artisan test

