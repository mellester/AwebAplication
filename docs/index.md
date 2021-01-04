These are my note about this project.

# Goal ## 
build a full stack we application using a fake marketplace.


## windows 10 setup ## 

I am using win 10 to develop this application so here are my notes on setting up. First some links
-  [Installing Windows Subsystem for Linux 2 ](https://docs.microsoft.com/nl-nl/windows/wsl/install-win10) aka wsl2
- [setup docker](https://docs.microsoft.com/en-us/windows/wsl/tutorials/wsl-containers)
- [Docker in wsl 2](https://code.visualstudio.com/blogs/2020/03/02/docker-in-wsl2) Same as above link


I already had wsl1 and the correct win10 buil installed so I only had to run in powershel
```powershell
dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
```
Also I had to downlaod and install
 * [WSL2 Linux kernel update package for x64 machines](https://docs.microsoft.com/nl-nl/windows/wsl/install-win10#step-4---download-the-linux-kernel-update-package)

Then I ran
 ```powershell
PS C:\Users\melle> wsl --set-default-version 2
 ```
Then I instaled a ubuntu distription from the store
![image](./images/Screenshot_2020-12-31_104634.png)

Afterwards I run  the following
 ```powershell
PS C:\Users\melle> wsl --list -v
  NAME            STATE           VERSION
* Ubuntu          Stopped         1
  Ubuntu-20.04    Running         2
```

To check and see if it is installed with the proper version.
I also like to run 
```powershell
PS C:\Users\melle> wsl --set-default Ubuntu-20.04
```

which sets the defualt distrobution for my machine

### instaling docker
follow the steps from 
[setup docker](https://docs.microsoft.com/en-us/windows/wsl/tutorials/wsl-containers)
![image](./images/Screenshot_2020-12-31_110319.png)


Then had to add my username to the docker-group.
Using a elaveted powershell prompt I have run.
```powershell
Add-LocalGroupMember -Group "docker-users" -Member "melle" 
```

Melle is my username on my pc. You should use your own.

---

>**How to move wls2 To a diffrent hard drive** |

| See this link on [stackoveflow](https://stackoverflow.com/a/62533123/3599)              |
|----------------------------------------------------------------------------------------:|
## Limit memeory usage of docker ##
In a powrshell or cmd promt do the follwing
```powershell
wsl --shutdown
notepad "$env:USERPROFILE/.wslconfig"
```
This opens up a config file or creates one in you user folder.
In this folder add the following.
```
[wsl2]
memory=4GB   # Limits VM memory in WSL 2 up to 3GB
processors=4 # Makes the WSL 2 VM use two virtual processors
```


## Install laravel jetsream

```Bash
cd ~
#create a new laravel project
composer create-project laravel/laravel AwebAplication 
#add jetstream strater kit 
composer require laravel/jetstream
#make sure sail is installed
composer require laravel/sail --dev
#Make A allias to sail
echo "alias sail=./vendor/bin/sail" >> ~/.bash_aliases 
source ~/.bash_aliases #load said allias  
php artisan jetstream:install inertia
sudo apt install -y npm
npm install && npm run dev
```
##  Setup ngrock ## 

