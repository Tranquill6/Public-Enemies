<script type='module'>
    let timers = {{ Js::from($characterData['timers']) }};

    initializeTimers();

    let updateTimers = setInterval(() => {
        let removeIds = [];
        $('.headerTimer').each(function() {
            //initialize dates
            let nowTime = new Date();
            let timerTime = new Date($(this).find('.timerTime').attr('time-expires'));
            //use some magic to turn the string into a proper format or else the hours will get messed up
            timerTime = timerTime.toISOString().split("T")[0].split(".")[0] + ' ' + timerTime.toISOString().split("T")[1].split(".")[0];
            //re-initialize the date with the new proper string
            let timerTime2 = new Date(timerTime);
            //get the difference between now and the timer's time
            let timeMath = timerTime2.getTime() - nowTime.getTime();
            //calculate minutes and seconds
            let minutes = Math.floor((timeMath % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeMath % (1000 * 60)) / 1000);
            //if seconds is less than 10, append a 0 in front for it to look better
            seconds = seconds < 10 ? '0' + seconds : seconds;
            //if minutes and seconds are less than zero, remove timer
            if(minutes <= 0 && seconds <= 0) {
                $(this).remove();
                removeIds.push($(this).find('.timerTime').attr('timer-id'));
            }
            //else adjust the timer with the new time
            $(this).find('.timerTime').text(`${minutes}:${seconds}`);
        });
        if(removeIds.length > 0) {
            removeTimer(removeIds);
        }
    }, 1000);

    //See comments above, initializes timers for user
    function initializeTimers() {
        let timerHTML = ``;
        let removeIds = [];
        for(let index in timers) {
            let timer = timers[index];
            let color = '';
            let icon = '';
            //change color depending on type of timer
            switch(timer['type']) {
                case 'crime':
                    color = 'bg-sky-500';
                    icon = 'fa-people-robbery';
                    break;
                case 'travel':
                    color = 'bg-green-500';
                    icon = 'fa-plane';
                    break;
                case 'shoot':
                    color = 'bg-red-500';
                    icon = 'fa-gun';
                    break;
            }
            //decide which time to start the timer on
            let nowTime = new Date();
            let timerTime = new Date(timer['expires']);
            timerTime = timerTime.toISOString().split("T")[0].split(".")[0] + ' ' + timerTime.toISOString().split("T")[1].split(".")[0];
            let timerTime2 = new Date(timerTime);
            let timeMath = timerTime2.getTime() - nowTime.getTime();
            let minutes = Math.floor((timeMath % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeMath % (1000 * 60)) / 1000);
            seconds = seconds < 10 ? '0' + seconds : seconds;
            if(minutes > 0 || seconds > 0) {
                timerHTML += `<div id='timer-${timer['id']}' type='${timer['type']}' class='headerTimer w-20 h-6 px-1 rounded-md text-right text-white ${color}'><i class="fa-solid ${icon} float-left mt-1"></i><span class='timerTime' timer-id='${timer['id']}' time-expires='${timer['expires']}'>${minutes}:${seconds}</span></div>`;
            } else {
                removeIds.push(timer['id']);
            }
        }
        $('#timerContainer').append(timerHTML);
        if(removeIds.length > 0) {
            removeTimer(removeIds);
        }
    }

    function removeTimer(timerIds) {
        $.ajax({
            type: 'POST',
            url: `{{ route('play.removeTimer') }}`,
            data: {
                'timerIds' : timerIds
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // need this otherwise the request will get a csrf mismatch error
            },
            success: function(result) {
                console.log("timers removed!");
            },
            error: function(result) {
                console.log("error!");
            },
        })
    }

</script>

<div class='flex flex-row flex-nowrap h-8'>

    <!-- Bars -->
    <div id='barsContainer' class='inline-flex justify-evenly shrink items-center w-1/3 border-r-gray-500 border-r-2 px-2'>
        <div id='healthContainer'>
            <i class="text-green-400 text-xl fa-solid fa-heart"></i>
            <div id='healthBar' class='inline-flex bg-slate-900 w-32 h-4 border-2 border-slate-600'>
                <div id='health' class='bg-green-400 h-3' style='width: {{ $characterData['health'] }}%'></div>
            </div>
            <span class='inline-flex text-center text-white ml-2'>{{ $characterData['health'] }}</span>
        </div>
        <div id='moneyContainer' class='inline-flex'>
            <span class='text-white'>Money:</span>
            <span class='text-green-400 ml-2'>${{ $characterData['money'] }}</span>
        </div>
    </div>

    <!-- Other Info -->
    <div id='miscContainer' class='inline-flex justify-evenly shrink items-center w-1/3 border-r-gray-500 border-r-2 px-2'></div>

    <!-- Timers -->
    <div id='timerContainer' class='inline-flex items-center gap-2 w-1/3 px-2'></div>

</div>