# kkard2's Colobot any% [warpless/sla] speedrunning ruleset
I decided to create my own ruleset because I disagree with a few rules and
wording choices on the
[speedrun.com leaderboard](https://www.speedrun.com/colobot). Changes are
pretty minor (except time-warping), but I still wanted to put it out there.
Some rules are copied from there, and some are modified or extended.

## Timing rules
- Timer follows Real-Time Attack (RTA).
- Load times are not excluded because it's too annoying to do so manually and
  there is no automatic solution that I know of.
- The timer starts when clicking "Play" on the first mission. This differs from
  [speedrun.com rules](https://www.speedrun.com/colobot?h=Any-colobot-gold-edition&rules=game)
  rules, where timer starts either when clicking "New Game"
  or "selecting [...] the first mission in a chosen category". Current runs on
  the leaderboard already don't adhere to starting the timer when clicking
  "New Game" so I think it's reasonable.
- The timer stops when the winning scene is displayed (the one with houses).
  This is different than "upon fulfilling the win condition of the final
  mission", because win conditions are fulfilled ~5 seconds before that, and I
  think it's a cleaner stopping point than the mission completed message.

## Game setup and modifications
- Mods, hacks or external tools affecting gameplay mechanics are
  **not allowed**.
- Cheats, debug commands and hidden CBOT functions are **not allowed**.
- Glitches and exploits are permitted, with the exception of ACE (arbitrary
  code execution).
- All scripts must be written **during the run** using the in-game editor;
  no pre-written or externally created scripts may be used or imported.
- Run should be started with a brand new player, which automatically clears
  scripts in the private folder. The game launch should be included in the
  recording to ensure no gliches resulting from game manipulation before
  the run (for example using ACE).
- Any official release game version from [colobot.info](https://colobot.info/)
  can be used. Using a version built from source code is **not allowed**.
- Game files cannot be modified externally.

## [warpless]
- Speed control (time-warping) is **not allowed**. This is in opposition to the
  current [speedrun.com rules](https://www.speedrun.com/colobot?h=Any-colobot-gold-edition&rules=game).
  If you want to know my reasoning try routing and playing a level with
  time-warp allowed (hint: it's not fun, at least for me).
  This is what "warpless" in square brackets stands for.

## [sla]
- Save-load abuse for in-game advantage is allowed
  (e.g. resetting `wait` function in CBOT, delaying lightining on Orpheon).
  This is what "sla" in square brackets stands for.

## Final notes
Technically under the above rules, my current PB (01:27:10) is invalid.
At 49:05 I accidentally clicked F8 key trying to load a quicksave with F9 key,
which resulted having time-warp enabled for a split second.
It didn't give me any advantage (I loaded a quick save after that),
but if you want to say my run is invalid under this ruleset go ahead.

I encourage future runs to disable these keybinds in the settings.
