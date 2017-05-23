<?php

// 1. fetch user by email
// 2. compare user password hash against given password
// 3. is the user banned? (optional)
// 4. log login (optional)
// 5. store user identifier into the session

// discuss: should the fetching by password happen at database level?
//          Should it happen inside the entity?
//          Or in a service?
