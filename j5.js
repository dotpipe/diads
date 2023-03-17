let audioCtxClone = Array;
let audioCtxMem = Array();
let audioCtxSubs = new Map();
let audioCtxPads = new Map();
let json = Array();
let triggerCnt = 8;
let KEYDOWN = "";
let counting = Array();

function createTriggers()
{
    var table = document.getElementById("trigger-table");
    let cnt = parseInt(document.getElementsByClassName("triggers").length);
    console.log(cnt);
    for (i = 1 ; i <= triggerCnt ; i++)
    {
        for (j = 1 ; j <= triggerCnt ; j++)
        {
            table.innerHTML = table.innerHTML + "<label class='triggers' id='" + (i).toString() + (j).toString() + "' style='border:1px dashed black;margin:5px;width:23px;color:red' active='false' oncontextmenu='padSend(this);' touchstart='playPauseSample(this)' onclick='playPauseSample(this)'>" + (i).toString() + "+" + (j).toString() + "</label>";
        }
        table.innerHTML = table.innerHTML + "<br>";
    }
    counting = Array();
    KEYDOWN = "";
}

function checks()
{
    const audioCtxt = new AudioContext();
    if (document.getElementsByClassName("oscillators").length > audioCtxClone.length)
        newAudio(document.getElementsByClassName("oscillators").length, audioCtxt);
    rates();
    audioCtxClone = Array();
    audioCtxMem = Array();
    audioCtxSubs = new Map();
    audioCtxPads = new Map();
    json = Array();
    document.querySelector("body").style.display = "block";
}

function analyzer()
{
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();

    const analyser = audioCtx.createAnalyser();
    analyser.fftSize = 2048;
    
    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);
    analyser.getByteTimeDomainData(dataArray);
    
    // Connect the source to be analysed
    source.connect(analyser);
    
    // Get a canvas defined with ID "oscilloscope"
    const canvas = ths.parentNode.getAttribute("index");
    const canvasCtx = canvas.getContext("2d");
    
    // draw an oscilloscope of the current audio source
    
    function draw() {
        requestAnimationFrame(draw);
        
        analyser.getByteTimeDomainData(dataArray);
        
        canvasCtx.fillStyle = "rgb(200, 200, 200)";
        canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
        
        canvasCtx.lineWidth = 2;
        canvasCtx.strokeStyle = "rgb(0, 0, 0)";
        
        canvasCtx.beginPath();
        
        const sliceWidth = (canvas.width * 1.0) / bufferLength;
        let x = 0;
        
        for (let i = 0; i < bufferLength; i++) {
            const v = dataArray[i] / 128.0;
            const y = (v * canvas.height) / 2;
        
            if (i === 0) {
                canvasCtx.moveTo(x, y);
            } else {
                canvasCtx.lineTo(x, y);
            }
        
            x += sliceWidth;
        }
        
        canvasCtx.lineTo(canvas.width, canvas.height / 2);
        canvasCtx.stroke();
    }
    
    draw();
    
}

function volume(ths, audio)
{
    const gain = audio.createGain();
    gain.gain.setValueAtTime(parseFloat(ths/10000),audio.currentTime);
    
    rates();
    return audio;
}

function newOscillator()
{
    // create web audio api context
    
    const audio = new AudioContext();
    const oscillator = audio.createOscillator();
    oscillator.type = "sine";
    oscillator.frequency.setValueAtTime(0,audio.currentTime);
    var sc = document.getElementById("slidecontainer");
    var st = document.getElementsByClassName("oscillators");
    if (st.length > 0)
    {
        alert("1 is all you get, swine.");
        return;
    }
    const str = st[0].innerHTML;
    
    var p = document.createElement("p");
    p.setAttribute("index", st.length);
    p.setAttribute("class", "oscillators");
    p.setAttribute("type", "sine");
    p.style.width = "fit-content";
    p.innerHTML = str;
    st[0].parentNode.append(p);
    oscillator.connect(audio.destination);
    i = 0;
    newAudio(p.childNodes[0], audio);
    rates();
    clearTabs(p);
    return oscillator;
}

function clearTabs(tabsObj, ths = null)
{
    var el = tabsObj.childNodes;
    var j = 0;
    for (i = 0 ; i < el.length ; i++)
    {
	    if ("object" == typeof(el[i]) && el[i].classList == "wavetype on")
            el[i].classList = "wavetype";
        if (ths == null && el[i].innerHTML == "Sine")
        {
            j = i;
        }
    }
    if (ths == null)
        el[j].classList.toggle("on");
    else
        ths.classList = "wavetype on";
}

function garbage(coll, indice)
{
    return {
        "audioctx": indice,
        "collection": coll
    };
}

document.addEventListener("keydown", (event) => {
	/*
		event.key returns the character being pressed
        event.preventDefault() prevents the default browser behavior for that shortcut, e.g. ctrl+r usually reloads the page, but event.preventDefault() will turn off that behavior. event.preventDefault() should only be used if you share a shortcut with the same trigger as the browser.
        event.ctrlKey / event.altKey / event.shiftKey / event.metaKey all return booleans. They will be true when they are being pressed, otherwise they will be false.
	*/
    event.preventDefault();
    var button = event.key;

    if (KEYDOWN != "" && Number.isInteger(parseInt(button)))
    {
        const vr = KEYDOWN + button;
        const btn = parseInt(button);
        document.getElementById(vr).click();
        KEYDOWN = "";
    }
    else if (Number.isInteger(parseInt(button)))
    {
        KEYDOWN = button; 
        console.log(button);
        console.log('...');
	}
});	

function playPauseSample(ths)
{
    var vcos = audioCtxPads;
    console.log(vcos);
    if (ths.getAttribute("active") == "true")
    {
        ths.setAttribute("active","false");
        for (i = 0 ; i < vcos.get(ths.id)[0].length ; i++)
        {
            console.log(vcos.get(ths.id));
            vcos.get(ths.id)[0][i].suspend();
        }
        audioCtxPads = vcos;
        ths.classList.toggle("on");
        return;
    }
    else if (ths.getAttribute("active") == "false") {
        ths.setAttribute("active","true");
        console.log(vcos); 
        for (i = 0 ; i < vcos.get(ths.id)[0].length ; i++)
        {
            vcos.get(ths.id)[0][i].resume();
        }
        audioCtxPads = vcos;
        ths.classList.toggle("on");
        return;
    }
    console.log(ths.getAttribute("active"));
}

function playPauseSampleKeyDown(ths)
{
    console.log(ths);
    var vcos = audioCtxPads[(ths.parentNode.getAttribute("index"))];
    console.log(vcos[ths.id]); 
    if (vcos == undefined)
        return;
    if (ths.getAttribute("active") == "true")
    {
        ths.setAttribute("active","false");
        for (i = 0 ; i < vcos.length ; i++)
        {
            vcos[ths.id][0][0][i].suspend();
        }
        audioCtxPads[(ths.parentNode.getAttribute("index"))] = vcos;
        ths.classList = "off";
        return;
    }
    else if (ths.getAttribute("active") == "false") {
        ths.setAttribute("active","true");
        console.log(vcos[ths.id][0]); 
        for (i = 0 ; i < vcos[ths.id][0][0].length ; i++)
        {
            vcos[ths.id][0][0][i].resume();
        }
        audioCtxPads[(ths.parentNode.getAttribute("index"))] = vcos;
        ths.classList = "on";
        return;
    }
}

function padSend(ths)
{
    const confrm = window.confirm("Overwrite Sample on Button " + ths.id + "?");
    if (confrm)
    {
        if (audioCtxMem.length == 0 || audioCtxMem == undefined)
        {
            window.alert("No Samples Loaded to Memory");
            return;
        }
        else if (audioCtxPads == undefined)
            audioCtxPads = new Map();
        named = ths.id;
        const x = ths.parentNode.parentNode.getAttribute("index");
        
        audioCtxPads.set(named, audioCtxMem);

        audioCtxMem = Array();
        ths.style.backgroundColor = "green";
        // audioCtxPads[(ths.parentNode.getAttribute("index"))][ths.id] = mem;
        // audioCtxPads[(ths.parentNode.getAttribute("index"))] = Array(y);
        console.log(audioCtxPads);
        window.alert("Copy Successful");
    }
    else
    {
        window.alert("Nothing Done.");
    }
}

function memHiDel()
{
    audioCtxMem.shift();
    document.getElementById("memoryCount").innerHTML = audioCtxMem.length;
}

function memAddOsc(ths)
{
    const coll = pauseOsc(ths);
    audioCtxMem.push(coll);
    document.getElementById("memoryCount").innerHTML = audioCtxClone.length;
    audioCtxClone = Array();
    if (audioCtxMem.length == 0)
        document.getElementById("memadd").classList(toggle);
    return;
}

function memGarbageCollector(ths)
{
    const coll = pauseOsc(ths);
    audioCtxGarbage[ths.name] = garbage(coll, ths.parentNode.getAttribute("index"));
    return;
}

function delOsc(ths)
{
    var vcos = audioCtxClone
    vcos[vcos.length-1].suspend();
    vcos.pop();
    audioCtxClone = vcos;
}

function changeType(ths, newType)
{
    ths.parentNode.setAttribute("type", newType);
    clearTabs(ths.parentNode, ths);
}

function oscillate(osc, audio)
{
    var oscillator = audio.createOscillator();
    oscillator.type = osc.parentNode.parentNode.getAttribute("type");
    var val = (osc.value);
    try {
        // oscillator.disconnect(audio.destination);
        oscillator.frequency.setValueAtTime(val,audio.currentTime);
    }
    catch {
        oscillator.frequency.setValueAtTime(val,audio.currentTime);
    }
    oscillator.connect(audio.destination);
    oscillator.start();
    rates();
    return audio;
}

function detune(val,audioCtx)
{
    const channelCount = 2;
    const frameCount = audioCtx.sampleRate * 2.0; // 2 seconds
    
    const myArrayBuffer = audioCtx.createBuffer(
      channelCount,
      frameCount,
      audioCtx.sampleRate
    );
    
    for (let channel = 0; channel < channelCount; channel++) {
      const nowBuffering = myArrayBuffer.getChannelData(channel);
      for (let i = 0; i < frameCount; i++) {
        nowBuffering[i] = Math.random() * 2 - 1;
      }
    }
    
    const source = audioCtx.createBufferSource();
    source.buffer = myArrayBuffer;
    source.connect(audioCtx.destination);
    source.detune.value = val; // value in cents
    return audioCtx;

}

function newAudio(osc)
{
    const hz = osc.value;
    const pc = osc.parentNode.parentNode.querySelector(".panning-control");
    const vc = osc.parentNode.parentNode.querySelector(".volume-control");
    const dc = osc.parentNode.parentNode.querySelector(".detuning-control");
    const th = osc.parentNode.parentNode.querySelector(".thresh-control");
    const ra = osc.parentNode.parentNode.querySelector(".ratio-control");
    const at = osc.parentNode.parentNode.querySelector(".attack-control");
    const rc = osc.parentNode.parentNode.querySelector(".release-control");
    const kn = osc.parentNode.parentNode.querySelector(".knee-control");


    let magic = Array({
        "index": {
            "id": osc.id,
            "wave": osc.parentNode.parentNode.getAttribute("type"),
            "hz": hz,
            "pc": pc.value,
            "vc": vc.value,
            "dc": dc.value,
            "th": th.value,
            "ra": ra.value,
            "at": at.value,
            "rc": rc.value,
            "kn": kn.value
        }
    });

    json.push(magic);
    let audio = new AudioContext();
    const compressor = audio.createDynamicsCompressor();
    compressor.threshold.setValueAtTime(th.value, audio.currentTime);
    compressor.knee.setValueAtTime(kn.value, audio.currentTime);
    compressor.ratio.setValueAtTime(ra.value, audio.currentTime);
    compressor.attack.setValueAtTime(at.value, audio.currentTime);
    compressor.release.setValueAtTime(rc.value/100, audio.currentTime);
    audio = pan(pc.value, audio);
    audio = volume(vc.value, audio);
    audio = detune(dc.value, audio);
    audio = oscillate(osc, audio);
    if (typeof(audioCtxClone) != "object")
        audioCtxClone = Array();
    audioCtxClone.push(audio);
}

function rates()
{
    var r = document.getElementsByClassName("slider");
    for (i = 0 ; i < r.length ; i++)
    {
        r[i].nextSibling.innerHTML = r[i].value;
    }
    var g = document.getElementsByClassName("hz-control");
    
    for (i = 0 ; i < g.length ; i++)
    {
        g[i].nextSibling.innerHTML = r[i].nextSibling.innerHTML;
        let freq = g[i].value;
        let j = 0;
        while (Math.ceil(freq) > 31)
        {
            freq = freq / 2;
            freq = Math.floor(freq);
            j++;
        }

        if (freq > 29)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " B";
        else if (freq > 28)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " A#/Bb";
        else if (freq > 26)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " A";
        else if (freq > 25)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " G#/Ab";
        else if (freq > 23)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " G";
        else if (freq > 22)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " F#/Gb";
        else if (freq > 21)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " F";
        else if (freq > 20)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " E";
        else if (freq > 19)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " D#/Eb";
        else if (freq > 18)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " D";
        else if (freq > 17)
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " C#/Db";
        else
            g[i].nextSibling.innerHTML = g[i].nextSibling.innerHTML + " C";
        freq--; 
    }
}

function playOsc(ths)
{
    var vcos = audioCtxClone;
    for (i = 0 ; i < vcos.length ; i++)
    {
        vcos[i].resume();
    }
    ths.classList.toggle("on");
    audioCtxClone = vcos;
    if (ths.nextSibling.nextSibling.classList == "play on")
        ths.nextSibling.nextSibling.classList.toggle("on");
}

function pauseOsc(ths)
{
    var vcos = audioCtxClone;
    console.log(vcos);
    for (i = 0 ; i < vcos.length ; i++)
    {
        vcos[i].suspend();
    }
    ths.classList.toggle("on");
    audioCtxClone = vcos;
    if (ths.previousSibling.previousSibling.classList == "play on")
        ths.previousSibling.previousSibling.classList.toggle("on");
    return audioCtxClone;
}

function deleteOscillator(t)
{
    t.stop();
    t.remove();
}

function pan(panner, audioCtx)
{
    const myAudio = document.getElementById("synthloops");

    const panControl = panner;
    // const panValue = document.querySelector(".panning-value");

    const htmlmed = document.createElement("audio"); //samples come in here

    // Create a MediaElementAudioSourceNode
    // Feed the HTMLMediaElement into it
    console.log(typeof(myAudio));
    const source = audioCtx.createMediaElementSource(htmlmed);

    // Create a stereo panner
    const panNode = audioCtx.createStereoPanner();

    // Event handler function to increase panning to the right and left
    // when the slider is moved
    const mth = panControl/100;
    panNode.pan.setValueAtTime(mth, audioCtx.currentTime);
    // connect the MediaElementAudioSourceNode to the panNode
    // and the panNode to the destination, so we can play the
    // music and adjust the panning using the controls
    rates();
    source.connect(panNode);
    panNode.connect(audioCtx.destination);
    return audioCtx;
}