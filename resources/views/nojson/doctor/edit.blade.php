<x-layout name='Oversight' role="Admin">
<x-slot:title>{{"$doctor->name | Edit"}}</x-slot:title>
<form action="{{route('doctor.update', ["doctor"=>$doctor->username])}}" enctype="multipart/form-data" class="content-container" data-action="update" data-type="doctor">
@method('PUT')
<section class="content-section">
<h3>Edit Doctor</h3>
<article class="form-box">
    <div>
        <label for="first-name">First name</label><input id="first-name" type="text" name="first_name" value="{{$doctor->first_name}}">
    </div>
    <div>
        <label for="last-name">Last name</label><input id="last-name" type="text" name="last_name" value="{{$doctor->last_name}}">
    </div>
    <div>
        <label for="username">Username</label><input id="username" type="text" name="username" value="{{$doctor->username}}">
    </div>
    <div>
        <label for="password">Password <span class="grey-font">(optional)</span></label>
        <input id="password" type="password" name="password">
        <div class="grey-font smaller-font field-guideline">If the password is not specified, the last name serves as the password during login.</div>
    </div>
    <div>
        <label for="password-confirmation">Confirm password</label><input id="password-confirmation" type="password" name="password_confirmation">
    </div>
    <div>
        <label for="passport" class="file-picker-label">Upload passport</label>
        <div class="file-picker">
            <div class='picker' data-destination="passport">Choose file</div>
            <div class='files_selected smaller-font'>No file selected.</div>
        </div>
        
        <input class="default-file-picker" id="passport" type="file" name="passport" accept="image/jpeg,image/jpg">
        <div class="grey-font smaller-font field-guideline">File must be jpeg and should not be larger than 1mb.</div>
    </div>
</article>
</section>

<section class="content-section">
<h3>Doctor's contact</h3>
<article class="form-box">
    <div>
        <label for="email">Email address</label><input id="email" type="text" name="email" value="{{$doctor->contact->email}}">
    </div>
    <div>
        <label for="phone">Phone number</label><input id="phone" type="text" name="phone_number" value="{{$doctor->contact->phone_number}}">
    </div>
    <div>
        <label for="preference">Preference</label>
        <select name="preference" id="preference">
            <option value="">---</option>
            <option value="email" @selected($doctor->contact->preference == 'email')>Email</option>
            <option value="sms" @selected($doctor->contact->preference == 'sms')>SMS</option>
        </select>
        <div class="grey-font smaller-font field-guideline">The doctor will be notified with through the means specified above.</div>
    </div>
</article>
</section>
<article class="buttons-box">
    <button id="cancel-reg" name="cancel" class="button">Cancel</button>
    <button id="submit" name="submit" class="button executor"><span>Edit</span></button>
</article>
</form>
</x-layout>