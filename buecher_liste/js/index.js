// Create needed constants
const list = document.querySelector('ul'); // book list
const sortDropdown = document.querySelector('#sort-dropdown'); // dropdown for sorting

// Add book form
const addBookForm = document.querySelector('#add-book-form');
const titleInput = document.querySelector('#title');
const authorInput= document.querySelector('#author');
const coverURLInput= document.querySelector('#cover-url');
const startDateInput= document.querySelector('#start-date');
const endDateInput= document.querySelector('#end-date');
const pageCountInput= document.querySelector('#page-count');
const submitBtn = document.querySelector('form button');

// Statistics at bottom of list
const stats = document.querySelector('#stats-content');
const statsBooksRead = document.querySelector('#stats-books-read');
const statsDaysPerBook = document.querySelector('#stats-days-per-book');
const statsPagesPerDay = document.querySelector('#stats-pages-per-day');
const statsCurrentlyReading = document.querySelector('#stats-currently-reading');
const statsTBR = document.querySelector('#stats-tbr');

let db;
window.onload = function() {
    let request = indexedDB.open('books_db', 1);

    // onerror handler signifies that the database didn't open successfully
    request.onerror = function() {
        console.log('Database failed to open');
    };
  
    // onsuccess handler signifies that the database opened successfully
    request.onsuccess = function() {
        console.log('Database opened successfully');
    
        // Store the opened database object in the db variable. This is used a lot below
        db = request.result;
    
        // Run the displayData() function to display the notes already in the IDB
        displayData();
    };

    // Setup the database tables if this has not already been done
    request.onupgradeneeded = function(e) {
        // Grab a reference to the opened database
        let db = e.target.result;
    
        // Create an objectStore to store our books in (basically like a single table)
        // including a auto-incrementing key
        let objectStore = db.createObjectStore('books_os', { keyPath: 'id', autoIncrement:true });
    
        // Define what data items the objectStore will contain
        objectStore.createIndex('title', 'title', { unique: false });
        objectStore.createIndex('author', 'author', { unique: false });
        objectStore.createIndex('coverURL', 'coverURL', { unique: false });
        objectStore.createIndex('startDate', 'startDate', { unique: false });
        objectStore.createIndex('endDate', 'endDate', { unique: false });
        objectStore.createIndex('pageCount', 'pageCount', { unique: false });
        objectStore.createIndex('rating', 'rating', { unique: false });
    
        console.log('Database setup complete');
    };
  
    // Create an onsubmit handler so that when the form is submitted the addData() function is run
    addBookForm.onsubmit = addData;

    // Define the addData() function
    function addData(e) {
        // prevent default - we don't want the form to submit in the conventional way
        e.preventDefault();
        
        // grab the values entered into the form fields and store them in an object ready for being inserted into the DB
        let newItem = { 
            title: titleInput.value, 
            author: authorInput.value, 
            coverURL: coverURLInput.value, 
            startDate: startDateInput.value, 
            endDate: endDateInput.value, 
            pageCount: pageCountInput.value
        };
    
        // open a read/write db transaction, ready for adding the data
        let transaction = db.transaction(['books_os'], 'readwrite');
    
        // call an object store that's already been added to the database
        let objectStore = transaction.objectStore('books_os');
    
        // Make a request to add our newItem object to the object store
        let request = objectStore.add(newItem);
        request.onsuccess = function() {
            // Clear the form, ready for adding the next entry
            titleInput.value = '';
            authorInput.value = '';
            coverURLInput.value = '';
            startDateInput.value = '';
            endDateInput.value = '';
            pageCountInput.value = '';
        };
    
        // Report on the success of the transaction completing, when everything is done
        transaction.oncomplete = function() {
            console.log('Transaction completed: database modification finished.');
        
            // update the display of data to show the newly added item, by running displayData() again.
            displayData();
        };
    
        transaction.onerror = function() {
            console.log('Transaction not opened due to error');
        };
    }

    // Listen to changes made to the sort-dropdown
    sortDropdown.onchange = function() {displayData(sortDropdown.value)};

     // Define the displayData() function
    function displayData(sortBy = 'title') {
        // Here we empty the contents of the list element each time the display is updated
        // If you didn't do this, you'd get duplicates listed each time a new note is added
        while (list.firstChild) {
        list.removeChild(list.firstChild);
        }
    
        // Open our object store and then get a cursor - which iterates through all the
        // different data items in the store
        let objectStore = db.transaction('books_os').objectStore('books_os');

        // Define variables for stats
        let daysRead = 0; // number of days added up from all books finished reading
        let numberOfBooksRead = 0; // number of books finished reading
        let numberOfBooksStarted = 0; // number of books started but not finished reading
        let numberOfBooksTBR = 0; // number of books not currently started
        let numberOfPages = 0;

        objectStore.index(sortBy).openCursor().onsuccess = function(e) {
            // Get a reference to the cursor
            let cursor = e.target.result;
        
            // If there is still another data item to iterate through, keep running this code
            if(cursor) {
                // Create a list item, h3, and p to put each data item inside when displaying it
                // structure the HTML fragment, and append it inside the list
                const listItem = document.createElement('li');
                const div1 = document.createElement('div');
                const div2 = document.createElement('div');
                const h3 = document.createElement('h3');
                const para = document.createElement('p');
                const pageC = document.createElement('span');
                const img = document.createElement('img');
        
                listItem.appendChild(div1);
                listItem.appendChild(div2);
                div1.appendChild(img);
                div1.setAttribute('class', 'img-container');
                div2.appendChild(h3);
                div2.appendChild(para);
                list.appendChild(listItem);

                // Put the data from the cursor inside the h3 and para
                h3.textContent = cursor.value.title;
                para.textContent = cursor.value.author;

                if (cursor.value.pageCount) {
                    pageC.setAttribute('class', 'pagecount');
                    pageC.innerHTML = `&nbsp; ${cursor.value.pageCount} S.`;
                    para.appendChild(pageC);
                }

                // Show cover for books where URL is given
                if (cursor.value.coverURL) {
                    img.src = cursor.value.coverURL;

                    // Mark books that have been started or finished reading on cover image
                    const marker = document.createElement('div');
                    marker.setAttribute('class', 'marker-status');

                    if (cursor.value.endDate === '' && cursor.value.startDate != '') {
                        div1.appendChild(marker);
                        marker.innerHTML = `<i class="fa-regular fa-clock"></i> &nbsp;Am Lesen`;
                        marker.setAttribute('title', `Seit ${cursor.value.startDate}`);
                    } else if (cursor.value.startDate != '' && cursor.value.endDate != '') {
                        div1.appendChild(marker);
                        marker.innerHTML = `<i class="fa-solid fa-check"></i> &nbsp;Gelesen`;
                        marker.setAttribute('title', `Gelesen vom ${cursor.value.startDate} bis zum ${cursor.value.endDate}`);
                    }
                } else {
                    // Hide cover where there is not URL
                    img.setAttribute('visibility', 'hidden');
                }
        
                // Store the ID of the data item inside an attribute on the listItem, so we know
                // which item it corresponds to. This will be useful later when we want to delete items
                listItem.setAttribute('data-book-id', cursor.value.id);
                
                // Create a delete button and place it inside each listItem
                const deleteBtn = document.createElement('button');
                div2.appendChild(deleteBtn);
                deleteBtn.textContent = 'Löschen';
                deleteBtn.setAttribute('data-book-id', cursor.value.id); //own
        
                // Set an event handler so that when the button is clicked, the deleteItem()
                // function is run
                deleteBtn.onclick = deleteItem;
                
                // Create an edit button and place it inside each listItem
                const editBtn = document.createElement('button');
                div2.appendChild(editBtn);
                editBtn.textContent = 'Bearbeiten';
                editBtn.setAttribute('data-book-id', cursor.value.id); //own
        
                // Set an event handler so that when the button is clicked, the openEditForm()
                // function is run
                editBtn.onclick = openEditForm;
                
                if (cursor.value.startDate === '') {
                    // Create an mark as read button and place it inside each listItem
                    const beginReadingBtn = document.createElement('button');
                    div2.appendChild(beginReadingBtn);
                    beginReadingBtn.textContent = '+';
                    beginReadingBtn.setAttribute('title','Zu Lesen beginnen');
                    beginReadingBtn.setAttribute('data-book-id', cursor.value.id); //own
            
                    // Set an event handler so that when the button is clicked, the openMarkReadForm()
                    // function is run
                    beginReadingBtn.onclick = openBeginReadingForm;

                    numberOfBooksTBR++;
                }
                
                if (cursor.value.endDate === '' && cursor.value.startDate != '') {
                    // Create an mark as read button and place it inside each listItem
                    const markReadBtn = document.createElement('button');
                    div2.appendChild(markReadBtn);
                    markReadBtn.textContent = '✓';
                    markReadBtn.setAttribute('title','Als gelesen markieren');
                    markReadBtn.setAttribute('data-book-id', cursor.value.id);
            
                    // Set an event handler so that when the button is clicked, the openMarkReadForm()
                    // function is run
                    markReadBtn.onclick = openMarkReadForm;

                    numberOfBooksStarted++;
                }

                if (cursor.value.startDate != '' && cursor.value.endDate != '') {
                    // Getting stats
                    let bookStartDate = new Date(cursor.value.startDate);
                    let bookEndDate = new Date(cursor.value.endDate);
                    let difference = bookEndDate.getTime() - bookStartDate.getTime();

                    daysRead += difference / (1000 * 3600 * 24);
                    numberOfBooksRead++;

                    if (cursor.value.pageCount) numberOfPages += new Number(cursor.value.pageCount);
                }
        
                // Iterate to the next item in the cursor
                cursor.continue();

            } else {
                // Again, if list item is empty, display a 'No books stored' message
                if (!list.firstChild) {
                    const listItem = document.createElement('li');
                    listItem.textContent = 'Keine Bücher gespeichert.';
                    list.appendChild(listItem);
                }

                // Getting stats
                let averageDays = 0;
                if (daysRead > 0 && numberOfBooksRead > 0) averageDays = Math.trunc(daysRead / numberOfBooksRead);
                let pagesPerDay = 0;
                if (daysRead > 0 && numberOfPages > 0) pagesPerDay = Math.trunc(numberOfPages / daysRead);

                // Displaying stats at bottom of page
                statsBooksRead.textContent = numberOfBooksRead;
                statsDaysPerBook.textContent = averageDays;
                statsPagesPerDay.textContent = pagesPerDay;
                statsCurrentlyReading.textContent = numberOfBooksStarted;
                statsTBR.textContent = numberOfBooksTBR;

                // Reset type of date inputs to show placeholder again in case someone clicked on the input fields
                startDateInput.type = 'text';
                endDateInput.type = 'text';
            }
        };
    }  
  
    // Define the deleteItem() function
    function deleteItem(e) {
        // retrieve the name of the task we want to delete. We need
        // to convert it to a number before trying to use it with IDB; IDB key
        // values are type-sensitive.
        let bookId = Number(e.target.getAttribute('data-book-id'));
    
        // open a database transaction and delete the task, finding it using the id we retrieved above
        let transaction = db.transaction(['books_os'], 'readwrite');
        let objectStore = transaction.objectStore('books_os');
        let request = objectStore.delete(bookId);
    
        // report that the data item has been deleted
        transaction.oncomplete = function() {
            // delete the parent of the button
            // which is the list item, so it is no longer displayed
            //original: e.target.parentNode.parentNode.removeChild(e.target.parentNode);
            const lis = list.querySelectorAll("li[data-book-id='" + bookId + "']"); //own
            lis.forEach(function(li) { //own
                list.removeChild(li);
              });
            console.log('Book ' + bookId + ' deleted.');
        
            // Again, if list item is empty, display a 'No books stored' message
            if(!list.firstChild) {
                let listItem = document.createElement('li');
                listItem.textContent = 'Keine Bücher gespeichert.';
                list.appendChild(listItem);
            }
        };
    }

    function openEditForm(e) {
        e.target.setAttribute('disabled','disabled');
        // retrieve the name of the task we want to edit. We need
        // to convert it to a number before trying it use it with IDB; IDB key
        // values are type-sensitive.
        let bookId = Number(e.target.getAttribute('data-book-id'));

        let transaction = db.transaction(['books_os'], 'readwrite');
        let objectStore = transaction.objectStore('books_os');
        let book = objectStore.get(bookId);

        book.onsuccess = function() {
            let editForm = document.createElement('li');
            editForm.setAttribute('id', 'edit-form-' + bookId);
            editForm.setAttribute('class', 'in-list-form');
            editForm.innerHTML = `<form id="edit-book"><h2>Buch bearbeiten</h2>
            <input id="edit-book-id" type="hidden" value="${bookId}">
            <div><input id="edit-title" type="text" placeholder="Titel" value="${book.result.title}" required></div>
            <div><input id="edit-author" type="text" placeholder="Autor*in" value="${book.result.author}" required></div>
            <div><input id="edit-cover-url" type="text" placeholder="URL zum Cover" value="${book.result.coverURL}"></div>
            <div><input id="edit-start-date" type="text" placeholder="Lesebeginn" onfocus="(this.type='date')" value="${book.result.startDate}"></div>
            <div><input id="edit-end-date" type="text" placeholder="Leseende" onfocus="(this.type='date')" value="${book.result.endDate}"></div>
            <div><input id="edit-page-count" type="number" placeholder="Seitenanzahl" value="${book.result.pageCount}" required></div>
            <div><button type="submit">Speichern</button>
            <button type="button" id="edit-cancel-button-${bookId}">Abbrechen</button></div></form>`;

            const lis = list.querySelectorAll("li[data-book-id='" + bookId + "']"); //own
            lis.forEach(function(li) { //own
                insertAfter(editForm, li);
            });

            // Create an onsubmit handler so that when the edit-form is submitted the editItem() function is run
            editForm = document.querySelector('#edit-book');
            editForm.onsubmit = editItem;

            let cancelBtn = document.querySelector('#edit-cancel-button-' + bookId);
            cancelBtn.onclick = function() {
                document.querySelector('#edit-form-' + bookId).remove();
                e.target.removeAttribute('disabled');
            };
        }
    }

    function editItem(e) {
        // prevent default - we don't want the form to submit in the conventional way
        e.preventDefault();
        let bookIdUpdate = document.querySelector('#edit-book-id');
        let titleUpdate = document.querySelector('#edit-title');
        let authorUpdate= document.querySelector('#edit-author');
        let coverURLUpdate= document.querySelector('#edit-cover-url');
        let startDateUpdate= document.querySelector('#edit-start-date');
        let endDateUpdate= document.querySelector('#edit-end-date');
        let pageCountUpdate= document.querySelector('#edit-page-count');
        
        // get Id of book to be updated from the hidden input
        let bookId = Number(bookIdUpdate.value);
                
        // grab the values entered into the form fields and store them in an object ready for being inserted into the DB
        let updatedItem = { 
            title: titleUpdate.value, 
            author: authorUpdate.value, 
            coverURL: coverURLUpdate.value, 
            startDate: startDateUpdate.value, 
            endDate: endDateUpdate.value, 
            pageCount: pageCountUpdate.value,
            id: bookId
        };


        // open a database transaction and edit the task, finding it using the id we retrieved above
        let objectStore = db.transaction(['books_os'], 'readwrite').objectStore('books_os');

        const request = objectStore.put(updatedItem);

        request.onsuccess = function() {
            document.querySelector('#edit-form-' + bookId).remove();
            console.log('Book ' + bookId + ' updated.');
            // update the display of data to show the updated item, by running displayData() again.
            displayData();
        };
    }

    function openBeginReadingForm(e) {
        e.target.setAttribute('disabled','disabled');
        // retrieve the name of the task we want to edit. We need
        // to convert it to a number before trying it use it with IDB; IDB key
        // values are type-sensitive.
        let bookId = Number(e.target.getAttribute('data-book-id'));

            let beginReadingForm = document.createElement('li');
            beginReadingForm.setAttribute('id', 'begin-reading-form-'+ bookId);
            beginReadingForm.setAttribute('class', 'in-list-form');
            Date.prototype.toDateInputValue = (function() {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0,10);
            });
            let date = new Date();
            beginReadingForm.innerHTML = `<form id="begin-reading-book"><h2>Lesebeginn setzen</h2>
            <input id="begin-reading-book-id" type="hidden" value="${bookId}">
            <div><input id="edit-start-date" type="text" placeholder="Lesebeginn" onfocus="(this.type='date')" value="${date.toDateInputValue()}"></div>
            <div><button>Speichern</button>
            <button type="button" id="begin-reading-cancel-button-${bookId}">Abbrechen</button></div></form>`;

            const lis = list.querySelectorAll("li[data-book-id='" + bookId + "']"); //own
            lis.forEach(function(li) { //own
                insertAfter(beginReadingForm, li);
            });

            // Create an onsubmit handler so that when the edit-form is submitted the editItem() function is run
            beginReadingForm = document.querySelector('#begin-reading-book');
            beginReadingForm.onsubmit = beginReadingItem;

            let cancelBtn = document.querySelector('#begin-reading-cancel-button-' + bookId);
            cancelBtn.onclick = function() {
                document.querySelector('#begin-reading-form-' + bookId).remove();
                e.target.removeAttribute('disabled');
            };
    }

    function beginReadingItem(e) {
        // prevent default - we don't want the form to submit in the conventional way
        e.preventDefault();
        let bookIdUpdate = document.querySelector('#begin-reading-book-id');
        let startDateUpdate= document.querySelector('#edit-start-date');
        
        // get Id of book to be updated from the hidden input
        let bookId = Number(bookIdUpdate.value);

        let transaction = db.transaction(['books_os'], 'readwrite');
        let objectStore = transaction.objectStore('books_os');
        let book = objectStore.get(bookId);

        book.onsuccess = function() {
            // grab the values entered into the form fields and store them in an object ready for being inserted into the DB
            let updatedItem = { 
                title: book.result.title, 
                author: book.result.author, 
                coverURL: book.result.coverURL, 
                startDate: startDateUpdate.value, 
                endDate: book.result.endDate, 
                pageCount: book.result.pageCount,
                id: bookId
            };


            // open a database transaction and edit the task, finding it using the id we retrieved above
            let objectStore = db.transaction(['books_os'], 'readwrite').objectStore('books_os');

            const request = objectStore.put(updatedItem);

            request.onsuccess = function() {
                document.querySelector('#begin-reading-form-' + bookId).remove();
                console.log('Book ' + bookId + ' updated.');
                // update the display of data to show the updated item, by running displayData() again.
                displayData();
            };
        }
    }

    function openMarkReadForm(e) {
        e.target.setAttribute('disabled','disabled');
        // retrieve the name of the task we want to edit. We need
        // to convert it to a number before trying it use it with IDB; IDB key
        // values are type-sensitive.
        let bookId = Number(e.target.getAttribute('data-book-id'));

            let markReadForm = document.createElement('li');
            markReadForm.setAttribute('id', 'mark-read-form-' +  bookId);
            markReadForm.setAttribute('class', 'in-list-form');
            Date.prototype.toDateInputValue = (function() {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0,10);
            });
            let date = new Date();
            markReadForm.innerHTML = `<form id="mark-read-book"><h2>Leseende setzen</h2>
            <input id="mark-read-book-id" type="hidden" value="${bookId}">
            <div><input id="edit-end-date" type="text" placeholder="Leseende" onfocus="(this.type='date')" value="${date.toDateInputValue()}"></div>
            <div><button>Speichern</button>
            <button type="button" id="mark-read-cancel-button-${bookId}">Abbrechen</button></div></form>`;

            const lis = list.querySelectorAll("li[data-book-id='" + bookId + "']"); //own
            lis.forEach(function(li) { //own
                insertAfter(markReadForm, li);
            });

            // Create an onsubmit handler so that when the edit-form is submitted the editItem() function is run
            markReadForm = document.querySelector('#mark-read-book');
            markReadForm.onsubmit = markReadItem;

            let cancelBtn = document.querySelector('#mark-read-cancel-button-' + bookId);
            cancelBtn.onclick = function() {
                document.querySelector('#mark-read-form-' + bookId).remove();
                e.target.removeAttribute('disabled');
            };
    }

    function markReadItem(e) {
        // prevent default - we don't want the form to submit in the conventional way
        e.preventDefault();
        let bookIdUpdate = document.querySelector('#mark-read-book-id');
        let endDateUpdate= document.querySelector('#edit-end-date');
        
        // get Id of book to be updated from the hidden input
        let bookId = Number(bookIdUpdate.value);

        let transaction = db.transaction(['books_os'], 'readwrite');
        let objectStore = transaction.objectStore('books_os');
        let book = objectStore.get(bookId);

        book.onsuccess = function() {
            // grab the values entered into the form fields and store them in an object ready for being inserted into the DB
            let updatedItem = { 
                title: book.result.title, 
                author: book.result.author, 
                coverURL: book.result.coverURL, 
                startDate: book.result.startDate, 
                endDate: endDateUpdate.value, 
                pageCount: book.result.pageCount,
                id: bookId
            };


            // open a database transaction and edit the task, finding it using the id we retrieved above
            let objectStore = db.transaction(['books_os'], 'readwrite').objectStore('books_os');

            const request = objectStore.put(updatedItem);

            request.onsuccess = function() {
                document.querySelector('#mark-read-form-' + bookId).remove();
                console.log('Book ' + bookId + ' updated.');
                // update the display of data to show the updated item, by running displayData() again.
                displayData();
            };
        }
    }
  
    function insertAfter(newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
    }
};