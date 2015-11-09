# iPhone-JSON-Encoder
This is a web application that returns MySQL database information through a JSON formatted array by using PHP URL headers.

Installation:
Put the contents of this repository into a new folder called "app" inside of your websites root directory (or make manually configure the dir path in each of the proper files)

Use:
This app makes use of MySQL stored procedures.  It uses GET and POST requests through PHP headers to get information from the database.  

For example, if you wanted to call the procedure "getCard", which has a required parameter of card_id (we will use the card_id, 3), you would call the following URL:  

http://mywebsite/app/class/fetch.php?proc=getCard&type=card&params[]=3.  

The "type" parameter is simply for array readability, this can be whatever you like, in this case we used "card" because its returning a card.  

This example returns one result array, but multiple result arrays, and multiple procedure params are totally supported.
Please note, you will have to make your own database procedures.  To view working examples, visit the links below.

Working Example URLs:

http://tethyr.palmtree-studios.net/app/class/fetch.php?proc=getCard&type=card&params[]=2

http://tethyr.palmtree-studios.net/app/class/fetch.php?proc=getCardsAll&type=card
