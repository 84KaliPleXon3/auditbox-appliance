# This script was written to provide an easy way to get settings from an
#  ini file in bash, initially written to parse the audit device
#  file during checkin. It must be sourced from another script to be useful


#  Given an ini file path, a section in the ini file (surrounded by square
#  brackets), and a setting within the specified section, the found value
#  will be echoed, and the function will return 0
#
#  If the setting can't be found in the specified file, nothing will be
#  echoed, and the function will return 1
#
# If the specified ini file doesn't exist, nothing will be echoed, and
#  the function will return 2
#
# If the specified ini file exists, but is empty, nothing will be echoed,
#  and the function will return 3
getIniSetting() {
        # Make variables easier to understand
        local iniPath="$1"
        local sectionName="$2"
        local settingName="$3"

        # Bail out of the function if the specified ini file doesn't exist
        if [ ! -f "$iniPath" ]; then
                return 2
        fi

        # Bail out of the function if the specified ini file is empty
        if [ ! -s "$iniPath" ]; then
                return 3
        fi

        # Initialize the curSection variable, which will be used to keep
        #  track of which section in the file is being looked at as the
        #  below loop iterates through the specified ini file
        local curSection=''

        # Iterate through the specified ini file, line by line
        while read line; do
                # Skip blank lines
                if [ "$line" = '' ]; then
                        continue
                fi

                # Update the curSection variable, by looking for the specified
                #  section name, surrounded by square brackets. As an
                #  example: [DEFAULT] would be a valid section line
                if [[ $line =~ ^\[.*\] ]]; then
                        curSection="$(echo "$line" | sed -r 's/^\[|\]$//g')"
                        continue
                fi

                # If curSection hasn't been set yet, don't look for any matching
                #  sections, skip to the next line of the file
                if [ "$curSection" = '' ]; then
                        continue
                fi

                # If the section of the current file isn't the specified
                #  sectionName, skip to the next line of the file
                if [ "$curSection" != "$sectionName" ]; then
                        continue
                fi

                # Found the desired setting in the specified section, echo it,
                #  and return 0
                if [[ $line =~ ^[[:blank:]]*$settingName[[:blank:]]*=[[:blank:]]* ]]; then
                        echo "$line" | sed -r "s/^[[:blank:]]+?[^=]+=[[:blank:]]*['\"]?|['\"]?$//g"
                        return 0
                fi
        done < "$iniPath"

        # If control reaches here, the desired setting in the specified section
        #  couldn't be found, return 1
        return 1
}


