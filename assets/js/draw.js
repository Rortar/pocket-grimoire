import CharacterToken from "./classes/CharacterToken.js";
import Template from "./classes/Template.js";
import {
    empty,
    lookupOne,
    lookupOneCached
} from "./utils/elements.js";
import {
    post
} from "./utils/fetch.js";

CharacterToken.setTemplates({
    token: Template.create(lookupOne("#character-template"))
});

const storageKey = `pocket-grimoire-draw-${DRAW_SESSION.id}`;
const status = lookupOneCached("#draw-status");
const number = lookupOneCached("#draw-number");
const token = lookupOneCached("#draw-token");
const ability = lookupOneCached("#draw-ability");
const form = lookupOneCached("#draw-name-form");
const nameInput = lookupOneCached("#draw-name");

let claimToken = "";
let draftTimer = null;

function setStatus(message) {
    status.textContent = message;
}

function getStoredClaimToken() {

    try {
        return window.localStorage.getItem(storageKey) || "";
    } catch (error) {
        return "";
    }

}

function setStoredClaimToken(token) {

    try {
        window.localStorage.setItem(storageKey, token);
    } catch (error) {}

}

function renderSlot(slot) {

    const character = new CharacterToken(slot.character);

    number.textContent = I18N.drawPlayerNumber.replace("%number%", slot.number);
    number.hidden = false;

    empty(token).append(character.drawToken());

    ability.textContent = character.getAbility();
    ability.hidden = false;

    nameInput.value = slot.name || "";
    form.hidden = false;

    setStatus(
        slot.submitted
        ? I18N.drawSaved
        : (
            slot.name
            ? I18N.drawDraftSaved
            : I18N.drawClaimed
        )
    );

    if (!slot.submitted) {
        nameInput.focus();
    }

}

function saveName(submitted) {

    if (!claimToken) {
        return Promise.resolve();
    }

    const name = nameInput.value;

    if (submitted) {
        setStatus(I18N.drawSaving);
    }

    return post(URLS.name, {
        claimToken,
        name,
        submitted
    })
        .then((json) => {

            if (!json.success) {
                setStatus(json.message || I18N.drawClaimError);
                return;
            }

            setStatus(submitted ? I18N.drawSaved : I18N.drawDraftSaved);

        })
        .catch(() => {
            setStatus(I18N.drawClaimError);
        });

}

function scheduleDraftSave() {

    clearTimeout(draftTimer);
    draftTimer = setTimeout(() => {
        saveName(false);
    }, 350);

}

form.addEventListener("submit", (event) => {

    event.preventDefault();

    if (!nameInput.value.trim()) {
        form.reportValidity();
        return;
    }

    clearTimeout(draftTimer);
    saveName(true);

});

nameInput.addEventListener("input", scheduleDraftSave);

setStatus(I18N.drawClaiming);

post(URLS.claim, {
    claimToken: getStoredClaimToken()
})
    .then((json) => {

        if (!json.success) {
            setStatus(json.message || I18N.drawClaimError);
            return;
        }

        claimToken = json.claimToken;
        setStoredClaimToken(claimToken);
        renderSlot(json.slot);

    })
    .catch(() => {
        setStatus(I18N.drawClaimError);
    });
