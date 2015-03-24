export LANGUAGE=en_US.UTF-8
export LC_ALL=en_US.UTF-8

export PATH=$PATH:$HOME/.gem/ruby/1.8/bin:$HOME/.composer/vendor/bin
export XDEBUG_CONFIG="idekey=PHPSTORM"

export PS1='\[\033[01;32m\]\u@\h\[\033[01;34m\] \w\[\033[01;33m\]$(__git_ps1)\[\033[01;34m\] \$\[\033[00m\] '
export GIT_PS1_SHOWDIRTYSTATE=1

# make bash autocomplete with up arrow
bind '"\e[A":history-search-backward'
bind '"\e[B":history-search-forward'

cd /vagrant