import './bootstrap';

let file_pickers;
let file_picker_labels;
let buttons;
let submit_buttons;
let cancel_buttons;
let login_button;
// let executor_buttons;
let edit_buttons;
let delete_buttons;
let logout_button;
let notify_buttons;
let aside;
let main;
let page_load_spinner;
let csrf_token;
let spinner;

HTMLButtonElement.prototype.working = function () {
    this.isActive = true;
    spinner = document.createElement('div');
    spinner.className = 'spinner';
    this.insertBefore(spinner, this.lastChild);
    this.classList.add('active-button');
}
HTMLButtonElement.prototype.notWorking = function () {
    this.isActive = false;
    spinner.remove();
    this.classList.remove('active-button');
}

// THE FOLLOWING FUNCTION IS CALLED TO SET EVENTS AFTER PAGE LOAD OR POPSTATE EVENT
function setPostLoadEvents() {
    console.log('in post load event setter');
    file_pickers = document.querySelectorAll('.file-picker .picker');
    file_picker_labels = document.querySelectorAll('.file-picker-label');
    buttons = document.querySelectorAll('.button');
    submit_buttons = document.querySelectorAll('button[name="submit"]');
    cancel_buttons = document.querySelectorAll('button[name="cancel"]');
    login_button = document.querySelector('button[name="login"]');
    logout_button = document.querySelector('button[name="logout"]');
    // executor_buttons = document.querySelectorAll('.executor');
    edit_buttons = document.querySelectorAll('button[data-action="edit"]');
    delete_buttons = document.querySelectorAll('button[data-action="delete"]');
    notify_buttons = document.querySelectorAll('button[data-action="notify"]');
    aside = document.querySelector('aside');
    main = document.querySelector('main');
    page_load_spinner = document.querySelector('.page-load-spinner');
    csrf_token = document.querySelector('meta[name="csrf"]').content;


    // THE FOLLOWING ADDS FUNCTIONALITY TO SIDEBAR CONTROLLER 
    document.querySelectorAll('[class*=sidebar-controller]').forEach(controller => {
        controller.addEventListener('click', function (ev) {
            console.log(aside.style.left)
            // console.log('clicked')
            aside.classList.toggle('default');
            main.classList.toggle('default');
        });
    });
    
    // THE FOLLOWING SETS FILEPICKER BUTTON FUNCTIONALITY
    file_pickers.forEach(picker => {
        picker.addEventListener('click', function (e) {
            let selector = '#'+picker.getAttribute('data-destination');
            let destination = document.querySelector(selector);
            destination.click();
        });
    });
    
    file_picker_labels.forEach(label => {
        label.addEventListener('click', function (e) {
            e.preventDefault();
        });
    });

    // THE FOLLOWING REMOVES DEFAULT ACTIONS FROM BUTTONS
    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
        });
    });

    // THE FOLLOWING CAUSES FILE PICKER TO INDICATE NUMBER OF SELECTED FILES
    document.querySelectorAll('input[type=file]').forEach(field => field.addEventListener('change', function (e) {
        // console.log(field, field.parentElement);
        let text;
        switch (field.files.length) {
            case 0:
                text = 'No file selected';
                break;
            case 1:
                text = '1 file selected';
                break;
            default:
                text = field.files.length+' files selected';
                break;
            
        }
        field.parentElement.querySelector('.files_selected').textContent =  text;
    }));

    // THE FOLLOWING CHANGES STATE TO EDIT FORM
    edit_buttons.forEach(button => {
        button.addEventListener('click', async function (ev) {
            if (button.isActive) return;
            button.isActive = true;
            let path = `/${button.getAttribute('data-type')}/${button.getAttribute('data-id')}/edit`;
            // console.log(path);
            // let response = await fetch(path, {method: "get", headers: {'accept': 'application/json', 'x-csrf-token': csrf_token}});
            // document.location.pathname = path;
            // renderNewState(await prepareNewState(document.location.pathname));
            changeState({}, '', path);
        });
    });

    // THE FOLLOWvNG CHANGES STATE DELETE RESOURCES
    delete_buttons.forEach(button => {
        button.addEventListener('click', async function (ev) {
            // console.log('we are here');
            if (button.isActive) return;
            // button.working();
            // disableAllActions();
            show_modal_box(button);
            console.log('delete clicked');
            // return;
            document.querySelector('.modal-box [data-action="delete"]').addEventListener('click', async function (ev) {
                ev.preventDefault();
                if (this.isActive) return;
                this.working();
                // console.log('modal delete ckicked')
                let input = document.querySelector('.modal-box input').value;
                let response = await fetch(`/confirm_password?input=${input}`);
                let status = await response.json();
                console.log(status);
                this.notWorking();
                if (status['message'] == 'authorized') {
                    remove_modal_box();
                    await proceed_action(button);
                }
                // else {rollback_delete(modalBox);}
            });
            document.querySelector('.modal-box [data-action="cancel"]').addEventListener('click', function (ev) {
                remove_modal_box();
            });
        });
    });

    // THE FOLLOWING CANCELS FORM
    cancel_buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            history.back();
        });
    });
    
    // THE FOLLOWING SUBMITS FORMS (LOGIN, CREATE AND EDIT)
    submit_buttons.forEach(button => {
        button.addEventListener('click', async function (e) {
            if (button.isActive) return;
            button.working();
            let form = button.form;
            let formData = new FormData(button.form);
            // let spinner = document.createElement('div');
            let path = form.action;
            let action = form.getAttribute('data-action');
            let type = form.getAttribute('data-type');
            if (action == 'login') formData.append('role', type);
            // console.log(path);
            
            // spinner.className = 'spinner';
            // console.log(button.innerText)
            // console.log(spinner);
            // button.textContent = spinner+' '+button.textContent;
            // console.log(form);
            // let request = new HandleResponse(path);
            let response = await fetch(path, {method: "post", headers: {'accept': 'application/json', 'x-csrf-token': csrf_token}, body: formData});
            // console.log(document.querySelectorAll('.error_box'));
            button.notWorking();
            document.querySelectorAll('.error_box').forEach(box => box.remove());
            if (!response.ok) {
                let data = await response.json();
                // console.log(data);
                // console.log(data.errors);
                // Object.key
                // console.log(JSON.parse(data.errors));
                if (data.errors) {
                    // let field;
                    for (let key of Object.keys(data.errors)) {
                        let field = document.querySelector(`[name=${key}]`);
                        let parent = field.parentElement;
                        let messages = data.errors[key];
                        // console.log(messages);
                        let error_box = document.createElement('ul');
                        field.addEventListener('change', () => error_box.remove());
                        error_box.className = 'error_box';
                        for (let message of messages) {
                            let error = document.createElement('li');
                            error.textContent = message;
                            error_box.appendChild(error);
                        }
                        // if (field.alreadyHasErrorBox) field.nextElementSibling.remove();
                        parent.insertBefore(error_box, field.nextSibling);
                        // field.alreadyHasErrorBox = true;
        
                        // console.log(field);
                        // console.log(document.querySelector('[name="'+field+'"]'))
                    }
                    // console.log('has errors');
                }
            } else {
                // alert('okay');
                let handler = new HandleResponse(action, type);
                handler.handle(response);
            }
            // let submit = new SubmitForm(button.form);
            // submit.dec();
        })
    });

    // THE FOLLOWING LOGOUTS USERS
    logout_button.addEventListener('click', async function (e) {
        let button = e.target;
        if (button.isActive) return;
        // button.working();
        // disableAllActions();
        show_modal_box(button);
        console.log('logout clicked');
        // return;
        document.querySelector('.modal-box [data-action="logout"]').addEventListener('click', async function (ev) {
            ev.preventDefault();
            if (this.isActive) return;
            this.working();
            // console.log('modal delete ckicked')
            // let response = await fetch(`/logout`);
            // let status = await response.json();
            // console.log(status);
            this.notWorking();
            // if (status['message'] == 'authorized') {
                remove_modal_box();
                await proceed_action(button);
            // }
            // else {rollback_delete(modalBox);}
        });
        document.querySelector('.modal-box [data-action="cancel"]').addEventListener('click', function (ev) {
            remove_modal_box();
        });
    });


    // executor_buttons.forEach(button => {
    //     button.addEventListener('click', function (ev) {
    //         button.working();
    //     });
    // });
}






// THE FOLLOWING PREPARED THE NEW STATE OF THE PAGE AFTER A URL CHANGE
async function prepareNewState(requestParameters) {
    document.querySelector('.content-container').remove();
    page_load_spinner.classList.add('active');
    let headers = new Headers;
    headers.append('Accept', 'application/json');
    if (requestParameters.nocache) headers.append('Cache-Control', 'no-cache');
    // let method = method || 'get';
    let response = await fetch(requestParameters.url, {method: 'get', headers: headers});
    let data;
    let  content;
    if (response.ok) {
        data = await response.text();
        data = new DOMParser().parseFromString(data, 'text/html');
        content = data.querySelector('.content-container');
        // console.log('this is the response', content)
    }
    // console.log(await response.text());
    return content;
}

// THE FOLLOWING RENDERS THE NEWLY PREPARED STATE
function renderNewState(content) {
    // console.log(previousContent);
    document.title = content.getAttribute('data-title');
    // console.log(content, content.getAttribute('data-title'));
    page_load_spinner.classList.remove('active');
    document.querySelector('main').appendChild(content);
    setPostLoadEvents();
}

// THE FOLLOWING HANDLES CHANGING THE STATE OF THE PAGE
async function changeState(stateObject, title, path, nocache = null) {
    history.pushState(stateObject, title, path);
    renderNewState(await prepareNewState({url: path, nocache: nocache}));
}

// THE FOLLOWING PROCEEDS DELETE
async function proceed_action(button) {
    button.working();
    let action = button.getAttribute('data-action');
    let type = String(button.getAttribute('data-type')).toLowerCase();
    let path;// = `/${action.toLowerCase()}/${button.getAttribute('data-id')}`;
    let method;
    // alert(action);return;
    switch(action) {
        case "delete":
            path = `/${type}/${button.getAttribute('data-id')}`;
            method = 'delete';
            break;
        case "logout":
            path = `/logout/${type}`;
            method = 'get';
            break;
    }
    // alert(path);return;
    let response = await fetch(path, {method: method, headers: {'accept': 'application/json', 'x-csrf-token': csrf_token}});
    button.notWorking();
    if (response.ok) {
        let handler = new HandleResponse(action, type);
        handler.handle(response);
    }
}

// // THE FOLLOWING PROCEEDS DELETE
// async function proceed_logout(button) {
//     button.working();
//     let path = `/${button.getAttribute('data-type')}/${button.getAttribute('data-id')}`;
//     let response = await fetch(path, {method: "delete", headers: {'accept': 'application/json', 'x-csrf-token': csrf_token}});
//     button.notWorking();
//     if (response.ok) {
//         let handler = new HandleResponse('delete', button.getAttribute('data-type'));
//         handler.handle(response);
//     }
// }

// THE FOLLOWING DISABLES ALL ACTIONS WHEN MODAL IS UP
function show_modal_box(button, type) {
    // <div class="modal-box">
    //     <div class="content">
    //         <p>Are you sure you want to delete this doctor?</p>
    //         <p><input type="password" placeholder="input password..."></p>
    //         <p class="buttons-box"><button data-action="cancel" class="button modal-button">Cancel</button><button data-action="delete" class="button executor modal-button">Delete</button></p>
    //     </div>
    //     </div>
    let action = button.getAttribute('data-action');
    let screen = document.createElement('div');
    screen.className = 'screen';
    let modalBox = document.createElement('div');
    modalBox.className = 'modal-box';
    let messageP = document.createElement('p');
    let messageText;
    switch (action) {
        case 'delete':
            messageText = 'Are you sure you want to delete this doctor?';
            break;
        case 'logout':
            messageText = 'Are you sure you want to logout?';
            break;
    }
    messageP.appendChild(document.createTextNode(messageText));
    if (type == 'password') {
        let input = document.createElement('input');
        input.type = "password";
        input.placeholder = 'input password...';
        let inputP = document.createElement('p');
        inputP.appendChild(input);
    }
    let cancelB = document.createElement('button');
    cancelB.className = "button";
    cancelB.setAttribute('data-action', 'cancel');
    cancelB.textContent = 'Cancel';
    let actionB = document.createElement('button');
    actionB.className = "button";
    if (type == 'password') actionB.classList.add('executor');
    actionB.setAttribute('data-action', action);
    actionB.textContent = action.charAt(0).toUpperCase() + action.slice(1);
    let buttonsP = document.createElement('p');
    buttonsP.appendChild(cancelB);
    buttonsP.appendChild(actionB);
    buttonsP.className = 'buttons-box';
    modalBox.appendChild(messageP);
    if (type == 'password') modalBox.appendChild(inputP);
    modalBox.appendChild(buttonsP);
    screen.appendChild(modalBox);
    document.body.appendChild(screen);
    // console.log(modalBox);
    // modalBox.classList.add('show');
}

function remove_modal_box() {document.querySelector('.screen').remove();}

// function disableAllActions() {
//     console.log('disabling');
//     console.log(document.querySelectorAll('.button:not([class="modal-button"])'))
//     console.log(document.querySelectorAll('a'))
//     document.querySelectorAll('.button:not([class="modal-button"])').forEach(button => button.addEventListener('click', ev => ev.preventDefault()));
//     document.querySelectorAll('a').forEach(link => link.addEventListener('click', ev => ev.preventDefault()));
// }

// THE FOLLOWING ROLLS BACK DELETE
async function rollback_delete(modalBox) {
    modalBox.querySelector('input').value = '';
    modalBox.classList.remove('show');
}

//  THE FOLLOWING CLASS HANDLES REPONSES RETURNED FROM FORM SUBMISSION
class HandleResponse {
    constructor(action, type) {
        // console.log('orig path', path)
        this.action = action;
        this.type = type;
    }
    async handle(response) {
        let data;
        let redirect;
        switch (this.action) {
            case 'create':
                // console.log(params)
                data = await response.json();
                redirect = `/${this.type}/${data['username']}`;
                await changeState({username: data.username}, redirect, redirect);
                break;
            case 'update':
                // console.log(params)
                data = await response.json();
                redirect = `/${this.type}/${data['username']}`;
                await changeState({username: data.username}, redirect, redirect, {nocache: true});
                break;
            case 'delete':
                // console.log(params)
                console.log('inside delete action')
                // let data = await response.json();
                redirect = `/${this.type}/create`;
                await changeState({}, redirect, redirect, {nocache: true});
                break;
            case 'login':
                // console.log(params)
                console.log('inside login action')
                // let data = await response.json();
                redirect = `/${this.type}/home`;
                // await changeState({}, redirect, redirect, {nocache: true});
                document.location = redirect;
                break;
            case 'logout':
                // console.log(params)
                console.log('inside logut action')
                // let data = await response.json();
                redirect = `/${this.type}/login`;
                // await changeState({}, redirect, redirect, {nocache: true});
                document.location = redirect;
                break;
        
            default:
                // console.log('in default', this.path);
                // if (RegExp('/doctor/[\w\d]*').test(this.path)) {
                //     // console.log('we are editing');
                //     // return;
                //     let data = await response.json();
                //     let redirect = `/doctor/${data['username']}`;
                //     await changeState({username: data.username}, redirect, redirect, {nocache: true});
                // }
                break;
        }
    }
}


// THE FOLLOWING SETS BASIC FUNCTIONALITIES AFTER PAGE LOAD
window.addEventListener('load', function (ev) {
    setPostLoadEvents();
})

// THE FOLLOWING SETS THE STATE OF THE PAGE AFTER POPSTATE EVENT
window.addEventListener('popstate', async function (e) {
    setPostLoadEvents();
    renderNewState(await prepareNewState({url: document.location.pathname}));
});
