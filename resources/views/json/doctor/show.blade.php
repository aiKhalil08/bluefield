<section data-title="{{"$doctor->username | Doctor"}}" class="content-container">
    <article class="buttons-box">
       <button class="button" data-id="{{$doctor->username}}" data-action="edit" data-type="doctor">Edit</button>
       <button class="button executor" data-id="{{$doctor->username}}" data-action="delete" data-type="doctor"><span>Delete</span></button>
       <button class="button" data-id="{{$doctor->username}}" data-action="notify" data-type="doctor"><span>Notify</span></button>
    </article>
    <section class="content-section">
       <h3>Doctor's Information</h3>
       <article class="info-box">
           <div class="passport-container">
               <img class="passport" src="/storage/{{$doctor->picture->url}}?t={{time()}}" alt="Picture for Dr. {{$doctor->name}}">
           </div>
           <div class="left-border">
               <div class="bold-font">Name</div><div>{{$doctor->name}}</div>
           </div>
           <div class="left-border">
               <div class="bold-font">Username</div><div>{{$doctor->username}}</div>
           </div>
           <div class="left-border">
               <div class="bold-font">Phone number</div><div>{{$doctor->contact->phone_number}}</div>
           </div>
           <div class="left-border">
               <div class="bold-font">Email address</div><div>{{$doctor->contact->email}}</div>
           </div>
       </article>
       </section>
 </section>