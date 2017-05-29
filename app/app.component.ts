import {Component} from 'angular2/core';
import {RouteConfig,Router, ROUTER_DIRECTIVES} from 'angular2/router';
import { MainPageComponent } from './home/home.component';
import { LoginComponent}  from './login/login.component';
import { FindRoomComponent } from './findroom/findroom.component';
import { RegistrationComponent } from './registration/registration.component';

import { AddHotelComponent } from './AddHotel/addhotel.component';



@Component({
    selector: 'my-app',
	templateUrl: 'app/router.html',
	directives: [ROUTER_DIRECTIVES]
})

@RouteConfig([
  {path:'./',    name: 'Home',   component: MainPageComponent, useAsDefault: true},
  {path:'./login', name:'Login', component: LoginComponent},
  {path:'./register', name:'Register', component: RegistrationComponent},
  {path:'/findroom', name: 'FindRoom', component: FindRoomComponent},
    {path:'/addhotel', name: 'AddHotel', component: AddHotelComponent},



])

export class AppComponent {
	router: Router;

	constructor(router: Router) {
		this.router = router;
	}


}
