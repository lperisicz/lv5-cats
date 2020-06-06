// Zadatak 1 kod ide ovdje

class Game {

    constructor() {
        let elements = Array.prototype.slice.call(
            document.querySelectorAll(".fighter-box")
        );
        let leftSideElements = elements.slice(0, elements.length / 2);
        let rightSideElements = elements.slice(elements.length / 2, elements.length);
        let catInfos = Array.prototype.slice.call(
            document.querySelectorAll(".cat-info")
        );
        let images = Array.prototype.slice.call(
            document.querySelectorAll(".featured-cat-fighter-image")
        )
        this.left = leftSideElements;
        this.right = rightSideElements;
        this.leftInfo = catInfos[0];
        this.rightInfo = catInfos[1];
        this.leftImage = images[0];
        this.rightImage = images[1];
        this.fightButton = document.querySelector("#generateFight");
        this.randomButton = document.querySelector("#randomFight")
        this.gameTitle = document.querySelector("h2");
    }

    init() {
        this._attachListeners();
    }

    _setupUi() {
        this.rightImage.style.border = "none";
        this.leftImage.style.border = "none";
        this.gameTitle.innerHTML = "Choose your cat";
    }

    _attachListeners() {
        this.left.forEach(element => {
            element.style.pointerEvents = "auto";
            element.addEventListener("click", e => {
                e.preventDefault();
                this._onLeftItemCLick(element);
            });
        });
        this.right.forEach(element => {
            element.style.pointerEvents = "auto";
            element.addEventListener("click", e => {
                e.preventDefault();
                this._onRightItemCLick(element);
            });
        });
        this._changeButtonEnabled();
        this.fightButton.addEventListener("click", e => {
            e.preventDefault();
            this._onFightClick();
        }, {once: true});
        this.randomButton.disabled = false;
        this.randomButton.addEventListener("click", e => {
            e.preventDefault();
            this._onRandomClick();
        });
    }

    _onLeftItemCLick(element) {
        let data = JSON.parse(element.dataset.info);
        this.leftSelected = element;
        this._displayCatInfo(data, this.leftInfo);
        this._displayCatImage(element.children[0].src, this.leftImage);
        this._changeFighterEnabled(element, true);
        this._changeButtonEnabled()
    }

    _onRightItemCLick(element) {
        let data = JSON.parse(element.dataset.info);
        this.rightSelected = element;
        this._displayCatInfo(data, this.rightInfo);
        this._displayCatImage(element.children[0].src, this.rightImage);
        this._changeFighterEnabled(element, false);
        this._changeButtonEnabled()
    }

    _onFightClick() {
        let winner, looser;
        let winnerSideLeft = this._decideWinnerLeft(
            this.leftSelected,
            this.rightSelected
        );
        if(winnerSideLeft) {
            winner = this.leftSelected;
            looser = this.rightSelected;
        } else {
            winner = this.rightSelected;
            looser = this.leftSelected;
        }
        this._setupUi();
        this.left.forEach(element => {
            element.style.pointerEvents = "none";
            element.children[0].style.opacity = 0.4;
        });
        this.right.forEach(element => {
            element.style.pointerEvents = "none";
            element.children[0].style.opacity = 0.4;
        });
        this.fightButton.disabled = true;
        this.randomButton.disabled = true;
        setTimeout(() => {
            this.init()
            this._updateRecords(winner, looser);
            this._displayWinner(winner, looser);
            if (winnerSideLeft) {
                this._displayCatInfo(
                    JSON.parse(winner.dataset.info),
                    this.leftInfo
                );
                this._displayCatInfo(
                    JSON.parse(looser.dataset.info),
                    this.rightInfo
                );
            } else {
                this._displayCatInfo(
                    JSON.parse(winner.dataset.info),
                    this.rightInfo
                );
                this._displayCatInfo(
                    JSON.parse(looser.dataset.info),
                    this.leftInfo
                );
            }
            this._changeFighterEnabled(this.leftSelected, true);
            this._changeFighterEnabled(this.rightSelected, false);
        }, 3000)
    }

    _decideWinnerLeft(left, right) {
        let leftData = JSON.parse(left.dataset.info).record;
        let rightData = JSON.parse(right.dataset.info).record;
        let leftPercent = leftData.wins / (leftData.wins + leftData.loss);
        let rightPercent = rightData.wins / (rightData.wins + rightData.loss);
        let percent = Math.random();
        if(Math.abs(leftPercent - rightPercent) <= 0.1) {
            if(leftPercent > rightPercent) {
               return percent > 0.4; 
            } else {
                return percent <= 0.4; 
            }
        } else {
            if(leftPercent > rightPercent) {
                return percent > 0.3; 
             } else {
                 return percent <= 0.3; 
             }
        }
    }

    _onRandomClick() {
        var count = 0;
        var timer = setInterval(() => {
            if (++count == 6) clearInterval(timer);
            let size = this.left.length;
            let randomLeft = Math.round(Math.random() * (size - 1));
            let randomRight = Math.round(Math.random() * (size - 2));
            randomLeft = this.left[randomLeft];
            randomRight = this.right.filter(element =>
                JSON.parse(element.dataset.info).id != JSON.parse(randomLeft.dataset.info).id
            )[randomRight];
            this._onLeftItemCLick(randomLeft);
            this._onRightItemCLick(randomRight);
        }, 100);
    }

    _displayCatInfo(data, info) {
        let name = info.querySelector(".name");
        name.innerHTML = data.name;
        let age = info.querySelector(".age")
        age.innerHTML = data.age;
        let skills = info.querySelector(".skills")
        skills.innerHTML = data.catInfo;
        let record = info.querySelector(".record")
        record.innerHTML = `
        Wins: <span class="wins">${data.record.wins}</span> Loss: <span class="loss">${data.record.loss}</span>
        `;
    }

    _displayCatImage(url, imageElement) {
        this._setupUi();
        imageElement.src = url
    }

    _updateRecords(winner, looser) {
        let winnerData = JSON.parse(winner.dataset.info);
        winnerData.record.wins = winnerData.record.wins + 1;

        let looserData = JSON.parse(looser.dataset.info);
        looserData.record.loss = looserData.record.loss + 1;

        this.left.concat(this.right).forEach(element => {
            if(JSON.parse(element.dataset.info).id == winnerData.id) {
                element.dataset.info = JSON.stringify(winnerData);
            } else if(JSON.parse(element.dataset.info).id == looserData.id) {
                element.dataset.info = JSON.stringify(looserData);
            }
        })
    }

    _displayWinner(winner, looser) {
        if (this.leftImage.src == winner.children[0].src) {
            this.leftImage.style.border = "thick solid #00FF00";
            this.rightImage.style.border = "thick solid #FF0000";
        } else {
            this.rightImage.style.border = "thick solid #00FF00";
            this.leftImage.style.border = "thick solid #FF0000";
        }
        let data = JSON.parse(winner.dataset.info);
        this.gameTitle.innerHTML = `Winner is ${data.name} !!!`;
    }

    _changeFighterEnabled(selectedFighter, isLeft) {
        let selectedData = JSON.parse(selectedFighter.dataset.info);
        let selectedPanel;
        let otherPanel;
        if (isLeft) {
            selectedPanel = this.left;
            otherPanel = this.right;
        } else {
            selectedPanel = this.right;
            otherPanel = this.left;
        }
        otherPanel.forEach(element => {
            let data = JSON.parse(element.dataset.info);
            let same = selectedData.id == data.id;
            if (same) {
                element.style.pointerEvents = "none";
                element.children[0].style.opacity = 0.4;

            } else {
                element.style.pointerEvents = "auto";
                element.children[0].style.opacity = 1;
            }
        });
        selectedPanel.forEach(element => {
            let data = JSON.parse(element.dataset.info);
            let same = selectedData.id == data.id;
            if (same) {
                element.children[0].style.border = "thick solid #0000FF";
            } else {
                element.children[0].style.border = "none";
            }
        });
    }

    _changeButtonEnabled() {
        if (this.leftSelected && this.rightSelected) {
            this.fightButton.disabled = false;
        } else {
            this.fightButton.disabled = true;
        }
    }

}

let game = new Game();
game.init();