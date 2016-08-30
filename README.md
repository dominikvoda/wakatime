# WakaTime stats collector
Collection of simple SymfonyConsole commands for manage WakaTime tracking stats

## List of commands

### Summary
This commands load summary data from WakaTime. 

1. `summary:daily`
2. `summary:weekly`
3. `summary:monthly`
4. `summary:range`

###1. summary:daily
Load data for selected day. <br>**Default day is previous**

| Name              | Type      | Shortcut    | Default | Description |
| ----------------- | -------   | :---------: | ------- | ----------- |
| current           | Option    | `-c` || load current day |
| date              | Argument  || `N/A`| set day date to load **Y-m-d** |

###2. summary:weekly
Load data for selected week. <br>**Default week is previous**

| Name              | Type      | Shortcut    | Default | Description |
| ----------------- | -------   | :---------: | :-----: | ----------- |
| current           | Option    | `-c` || load current week |
| date              | Argument  || `N/A` | set date to find week to load **Y-m-d** |


###3. summary:monthly
Load data for selected month. <br>**Default month is previous**

| Name              | Type      | Shortcut    | Default | Description |
| ----------------- | -------   | :---------: | :-----: | ----------- |
| current           | Option    | `-c` || load current month |
| month-number      | Option    | `-m` || select month number (1 - 12) |
| year              | Option    | `-y` | current year | select year for month number |

###4. summary:range
Load data for selected range.

| Name              | Type      | Shortcut    | Default | Description |
| ----------------- | -------   | :---------: | :-----: | ----------- |
| start (required)  | Argument  || `N/A` | range start date **Y-m-d** |
| end               | Argument  || start date | range end date **Y-m-d** |
