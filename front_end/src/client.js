const baseURL = "http://api.cc.localhost"

const getCourses = category => {
    fetch(`${baseURL}/courses${category ? `?category_id=${category}` : ""}`, {
        method: "GET",
        mode:"cors",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(json => {
            const container = document.querySelector(".content");
            container.innerHTML = "";
            
            const grid = document.createElement("div");
            grid.classList.add("grid-container");

            json.courses.forEach(course => {
                const card = document.createElement("card");
                card.classList.add("card");
                
                const image = document.createElement("img");
                image.src = course["preview"]
                
                const courseName = document.createElement("p");
                courseName.innerText = course.name;
                courseName.classList.add("course-name");

                const p = document.createElement("p");
                p.innerText = course.description.length <= 140 ? course.description : `${course.description.substring(0, 120)}...`
            
                card.appendChild(image);
                card.appendChild(courseName);
                card.appendChild(p);

                grid.appendChild(card);
            });

            container.appendChild(grid);
        })
        .catch(err => {
            console.error("Server Error", err);
        });
}

const getCategories = () => {
    fetch(`${baseURL}/categories`, {
        method: "GET",
        mode:"cors",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .then(json => {
            constructCategoriesSidenav(json.categories);
        })
        .catch(err => {
            console.error("Server Error", err);
        });
}

const findCourseById = id => {
    fetch(`${baseURL}/courses/${id}`, {
        method: "GET",
        mode:"cors",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .catch(err => {
            console.error("Server Error", err);
        });
}

const findCategoryById = id => {
    fetch(`${baseURL}/categories/${id}`, {
        method: "GET",
        mode:"cors",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then(res => res.json())
        .catch(err => {
            console.error("Server Error", err);
        });
}

const init = async () => {
    try {
        await Promise.all([getCourses(), getCategories()]);
    } catch (error) {
        console.error("Initialization Error", error);
    }
}

const constructCategoriesSidenav = (categories, parentCategory = null) => {

    const ul = document.getElementById(`sub-categories-${parentCategory}`);

    categories.forEach(el => {
        if(el["parent_id"] == parentCategory) {
            const li = document.createElement("li");
            const subUl = document.createElement("ul");
            
            li.innerHTML = el["name"] + (el["course_count"] > 0 ? ` <span>(${el["course_count"]})</span>` : " ");
            li.id = el["id"];
            li.addEventListener("click", () => {
                document.querySelector(".active-category")?.classList.remove("active-category");
                li.classList.add("active-category");
                document.getElementById("title").innerText = el["name"];
                getCourses(el["id"]);
            });
            
            subUl.id = `sub-categories-${el["id"]}`;
            
            ul.appendChild(li);
            ul.append(subUl);

            constructCategoriesSidenav(categories, el["id"])
        }
    });
}

init();