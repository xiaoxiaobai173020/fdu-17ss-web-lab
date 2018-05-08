let container = document.getElementsByTagName("div")[0];

let additem = function(i) {
    let box = document.createElement("div");
    container.appendChild(box);
    box.className = "item";

    let h2 = document.createElement("h2");
    box.appendChild(h2);
    h2.innerHTML = countries[i].name;

    let p = document.createElement("p");
    p.innerHTML = countries[i].continent;
    box.appendChild(p);

    let box1 = document.createElement("div");
    box1.className = "inner-box";
    box.appendChild(box1);

    let h3 = document.createElement("h3");
    h3.innerHTML = "Cities";
    box1.appendChild(h3);

    let ul = document.createElement("ul");
    for (let a = 0; a < countries[i].cities.length; a++) {
        let li = document.createElement("li");
        li.innerHTML = countries[i].cities[a];
        ul.appendChild(li);
    }
    box1.appendChild(ul);

    let box2 = document.createElement("div");
    box2.className = "inner-box";
    box.appendChild(box2);

    let h3b = document.createElement("h3");
    h3b.innerHTML = "Popular Photos";
    box2.appendChild(h3b);
    for (let a = 0; a < countries[i].photos.length; a++) {
        let photo = document.createElement("img");
        photo.src = "images/" + countries[i].photos[a];
        photo.className = "photo";
        box2.appendChild(photo);
    }

    let bt = document.createElement("button");
    bt.innerHTML = "Visit";
    box.appendChild(bt);
}

additem(0);
additem(1);
additem(2);
additem(3);