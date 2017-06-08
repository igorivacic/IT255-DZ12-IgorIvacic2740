
import { Component, Directive } from 'angular2/core';
import {Http, HTTP_PROVIDERS, Headers} from 'angular2/http';
import {SearchPipe} from 'app/pipe/search';
import {SearchPipeKV} from 'app/pipe/searchKV';
import 'rxjs/Rx';
import {Router} from 'angular2/router';
import {FORM_DIRECTIVES , FORM_BINDINGS} from 'angular2/common';
@Component({
    selector: 'FindRoom',
    templateUrl: 'app/findroom/findroom.html',
    pipes: [SearchPipe, SearchPipeKV]
})

export class FindRoomComponent {
    http: Http;
    router:Router;
    beds:String ="";
    roomname:String ="";
    rooms: Object[];


    constructor(http: Http, router: Router){
        this.http = http;
        this.router = router;
        var headers = new Headers();

        http.get('http://localhost/php/getrooms.php',{headers:headers})
            .map(res => res.json())
            .subscribe(rooms => {this.rooms = rooms.rooms;
            });

    }

public removeRoom(event: Event, item: Number) {
var headers = new Headers();
headers.append('Content-Type', 'application/x-www-form-urlencoded');
headers.append('token', localStorage.getItem('token'));
this.http.get('http://localhost/php/deleterooms.php?id='+item,{headers:headers}) .subscribe( data => {
event.srcElement.parentElement.parentElement.remove();
});
}


}
