##################
# Laboratorium 2 #
##################

library(datasets)
cars

ramka=data.frame(
  Lp=1:10,
  Indeks=sample(10000:99999,10),
  Kol1=sample(1:50,10,replace=T),
  Kol2=sample(1:50,10,replace=T)
)
View(ramka)
ramka$Aktywnosc=sample(1:10,10,replace=T) ## Dokładanie
ramka$Indeks
View(ramka)
ramka$suma=rowSums()
getwd()


# Zadanie 1

# a) Przy u»yciu funkcji plot( ) narysować łamaną przechodzącą przez punkty
# (1, 20), (20, 30), (40, 13), (80, 25).
a=c(1,20,40,80) # x
b=c(20,30,13,25) # y
plot(a,b)

# b) Dodać tytuł "wykres 1", podpisać osie: "argumenty" i "wartości", odpowiednio.
plot(a,b, main="wykres1", xlim=c(0,100), ylim =c(0,100), las=1,
     xlab = 'argumenty', ylab = 'wartosci', lwd=3, col='red', lty=3,
     col.lab=4, col.main=5, type='o', pch=10)

# c) Do istniejącego wykresu dodać linię przechodzącą przez punkty (5, 30), (40, 20), (80, 3).
a2=c(5,40,80)
b2=c(30,20,3)
lines(a2,b2, col=7, lwd=2, lty=1,)

# d) Na istniejącym wykresie narysować punkty (−5, 50), (30, 10), (90, 40).
points(c(5,30,90), c(50,10,40), col=4, pch=21)


# Zad 2
# Za pomocą funkcji abline() w jednym układzie współrzędnych narysować:

# a) y = x, y = 2x, y = 3x, y = 4x, y = 5x, y = x + 2. Zastosować różne typy i różne grubości linii.
plot(1,1, type="n", xlim=c(0,20), ylim=c(0,20), las=1, xlab="arg", ylab="War")
abline(0,1, col=1, lwd=1, lty=1)
abline(0,2, col=2, lwd=2, lty=2)
abline(0,3, col=3, lwd=3, lty=3)
abline(0,5, col=4, lwd=4, lty=4)
abline(2,1, col=5, lwd=5, lty=5)

# b) y = 10
abline(h=10, col=6, lwd=6, lty=6)

# c) x = −20, x = 0, x = 20, x = 50, x = 150.
abline(v=c(0,2,4,7,10), col=7, lwd=3, lty=3)


# Zad 3
# Zainicjować okno graficzne, układ współrzędnych i osie.
# Za pomocą funkcji locator() zaznaczyć na wykresie pięć punktów.
# Wyświetlić współrzędne tych punktów.

plot(1,1, type="n", xlim=c(0,20), ylim=c(0,20), las=1, xlab="arg", ylab="War")
punkty=locator(n=5, type="p")
punkty
is.list(punkty)
points(punkty,col=2,cex=2)
x=punkty$x
y=punkty$y
i=seq(length(x)-1)
segments(x[i],y[i],x[i+1],y[i+1], col=3, lwd=2)


# Zad 4
# Narysować wykres

arg=seq(50,150,0.1)
arg
m=100
s=16
war=dnorm(arg,m,s)
plot(arg, war, las=1, type="l", col=2, lwd=2, xlab="arg", ylab="war",
     col.lab=3)
tytul=paste("Normalny, m=", m, "s=", s)
tytul
plot(arg, war, las=1, type="l", col=2, lwd=2, xlab="arg", ylab="war",
     col.lab=3, main = tytul, col.main=2, cex.main=1)

## drugi sposób
m=100
s=16
curve(dnorm(x,m,s),50,150,col="blue",las=1,lwd=2, xlab="arg", ylab="war",
      col.lab=3, main = tytul, col.main=3, cex.main=1)


# e) funkcji prawdopodobieństwa rozkładu Poissona o parametrze λ = 7.
# Dodać tytuł do wykresu: "Poisson, λ = 7";
x1=c(0:20)
lam=7
tytul=paste("Poisson, lambda=",lam)
plot(x1, dpois(x1,lam), las=1, type="h", col=3, lwd=3, xlab="arg", ylab="war",
     col.lab=5, main = tytul, col.main=5, cex.main=1)


# Zad 5
# Za pomocą funkcji plot() narysować okrąg o środku w punkcie (0, 0) i promieniu 1.
# Wykorzystać równanie parametryczne okręgu.

t=seq(0,2*pi,0.1)
x=cos(t)
y=sin(t)
plot(x,y, type="l", col=2, las=1, asp=1)

t=seq(0,2*pi,length.out=100) #ciąg arytmetyczny
x=cos(t)
y=sin(t)
plot(x,y, type="l", col=2, las=1, asp=1)

t2=seq(0,2*pi,length.out=6)
x=cos(t2)
y=sin(t2)
points(x,y, col=3, las=1, asp=1, pch=16)
arrows(cos(t2),sin(t2),cos(t2)-sin(t2),sin(t2)+cos(t2), length=0.09,
       angle=10)


# Zad 6
# Napisać funkcję, która zwraca wartość funkcji f(x) = x · sin x.

fun = function(x){
  y = x*sin(x)
  return(y)
}
fun(1)
curve(fun, -10, 10, n=100, lwd=2, lty=4, col=3, las =1)
abline(h=0,v=0)


# Zad 7
# (1) Za pomocą instrukcji if...else... napisać funkcję f(x) = { x², x ≥ 0; −x, x < 0.
# (2) Za pomocą funkcji plot() narysować wykres funkcji z punktu (1) na przedziale (−5, 5).
fun2 = function(x){
  y=numeric()
  if(x>=0){
    y=x^2
  }
  else{
    y=-x
  }
  return(y)
}

fun2(-3)
arg=seq(-5,5,0.1)
arg
war=fun2(arg)
war=sapply(arg,fun2) # zeby zwektoryzowac
war
plot(arg, war, las=1, lwd=2, col=3, lty=2, type="l")
abline(v=0,h=0)


# Zad dodatkowe
par(mfrow=c(1,3))

curve(x^2,-5,5,las=1)
curve(x^3,-5,5,las=1)
curve(x^4,-5,5,las=1, col=2)
abline(v=0,h=0)
dev.off()


# Zad 9
# Napisać funkcję, która losuje bez powtórzeń sześć liczb ze zbioru
# {1, 2, . . . , 49}, następnie dla zadanego wektora sześciu liczb sprawdza
# ile jest trafień i wyświetla w postaci napisów:
# "Twoje liczby:", "Losowanie:", "Ilość trafionych:".
setequal(c(1,1,2), c(1,2))
v1=c(1,1,2,3,4,4,5,6)
v2=c(2,2,3,3)
v3=c(12)
intersect(v1,v2)
union(v1,v3)
setdiff(v2,v3)
print(paste("wektor=", c(1,2,3))) # wektoryzuje
cat("wektor=", c(1,2,3)) # laczy i drukuje, nie wektoryzuje

set.seed(1113)
lotto=function(kupon){
  los=sample(c(1:49), 6, replace=F)
  traf=length(intersect(los,kupon))
  cat("Twoje liczby: ", sort(kupon), "\n")
  cat("Losowanie: ", sort(los), "\n")
  cat("Il. trafien: ", traf, "\n")
}

lotto(c(2,3,6,35,17,45,8))

# Zad 10
# Napisać funkcję obliczającą losowe przybliżenie liczby π metodą Monte Carlo.
x=runif(1000,0,1)
y=runif(1000,0,1)
plot(x,y, las=1, asp=1, cex=0.5)
rect(0,0,1,1)
t=seq(0,2*pi, length.out=100)
x1=0.5+0.5*cos(t)
y1=0.5+0.5*sin(t)
lines(x1,y1, col=2)
indeks=which((x-0.5)^2+(y-0.5)^2<=0.25)
indeks
plot(x[indeks], y[indeks], las=1, xlim=c(0,1), ylim=c(0,1), cex=0.5, col=3, asp=1)
pi_est=4*length(indeks)/length(x)



##################
# Laboratorium 3 #
##################

# Zad 1
# Niech dane=rnorm(50, 100, 16)
set.seed(145)

# a) Narysować histogram dla tej próbki.
dane=rnorm(67,mean=100,sd=17)
dane
hist(dane)
range(dane)
h=hist(dane, xlim=c(50,150), ylim=c(0,20), los=1, col=2)
h
str(h)

# b) Na wykres histogramu (na wysokości osi Ox) "nałożyć" wykres samej próbki i zaznaczyć środki przedziałów.
stripchart(dane, pch=16, at=0, add=T)

stripchart(h$mids, pch=17, col=3, at=0, add=T) # Srodki

# c) Na wykresie histogramu zaznaczyć (nad każdym "słupkiem") liczebność każdego przedziału.
text(h$mids,h$counts+1.5,labels=h$counts,cex=0.8, xpd=T)
box()

# d) Obliczyć średnią z próbki i średnią z szeregu rozdzielczego. Porównać wartości.
mean(dane)
sum(dane)/length(dane)

str(h)
h$mids
h$counts
weighted.mean(h$mids, h$counts)
sum(h$mids*h$counts/length(dane))

# e) Obliczyć wariancję dla danych zgrupowanych i niezgrupowanych.
var(dane) # Wariancja skoregowana
sum((dane-mean(dane)^2)/length(dane))
sum((dane-mean(dane)^2)/length(dane)-1)

m2=weighted.mean(h$mids, h$counts)
m2

sum(h$counts*(h$mids-m2)^2 /length(dane)-1)

# f) Na histogramie zaznaczyć średnią z próbki.
abline(v=mean(dane), col=3, lwd=3)


# Zad 2
# Niech dane2=rnorm(1000, 100, 16)
# a) Narysować histogram dla tej próbki. Przyjąć, że liczba klas jest równa 50.
# b) Na wykres histogramu "nałożyć" wykres gęstości zmiennej losowej o rozkładzie N(100, 16).
# c) Narysować histogram2 tej próbki, w którym wektor wartości "dzielących" próbkę jest następujący: c(30, 50, 60, 70, 90, 110, 150, 160).
# d) Na wykres histogramu2 "nałożyć" wykres gęstości zmiennej losowej o rozkładzie N(100, 16).

dane2=rnorm(1000,100,16)
dane2
range(dane2)

h2=hist(dane2, las=1, col=4, xlim=c(45,165), ylim=c(0,60), breaks=50)

h3=hist(dane2, las=1, col=4, xlim=c(45,165), 
        breaks=50, freq = F)

curve(dnorm(x,100,16), 45, 165, col=7, add=T)

h4=hist(dane2, las=1, col=3, xlim=c(45,165), 
     breaks=c(30,50,60,70,90,110,150,160), freq = F)
curve(dnorm(x,100,16), 45, 165, col=2, add=T, xpd=T)


# Zad 5
# Narysować obok siebie dwa histogramy: wzrostu kobiet i mężczyzn.
# Potrzebne dane zawarte są w ramce danych bdims (plik csv01bdims).
# Wykorzystać funkcję `pretty()`.

x1=rnorm(200,100,16)

R=read.csv2(file.choose(), header=TRUE, sep=",", dec=".")
View(R)

str(R)
R2= R[c("hgt", "sex")]
head(R2)
h5=hist(R2$hgt) # histogram wzrostu
M=subset(R,sex==1)
M
K=subset(R,sex==0)
K
h6= hist(M$hgt, las=1, col=4)
h7= hist(K$hgt, col=5, add=T)

min(M$hgt, K$hgt)
max(M$hgt, K$hgt)
granice=pretty((min(M$hgt, K$hgt) - 1):(max(M$hgt, K$hgt) + 1),
               n=25)
granice

hist(K$hgt, breaks=granice, col=rgb(0.7,0.2,0,0.6), las=1,
     xlim=c(min(K$hgt), max(K$hgt + 20)), ylim=c(0,60), xlab="wzrost",
     main="Porównanie histogramów")
hist(M$hgt, breaks=granice, col=rgb(0.2,0.9,0,0.6), add=T)

P=locator()
legend(P, fill=c(rgb(0.7,0.2,0,0.6), rgb(0.2,0.9,0,0.6)),
       legend=c("wzrost kobiet", "wzrost mężczyzn"),
       ncol=2, xpd=T, cex=0.5)


# Zad 6
# Wygenerować 15-elementową próbę z rozkładu chi-kwadrat χ²(10).
# Narysować dystrybuantę empiryczną tej próbki.
# Na wykres dystrybuanty empirycznej "nałożyć" wykres dystrybuanty teoretycznej.
# Na poziomie osi Ox nałożyć wykres próbki (funkcja stripchart).

chi2=rchisq(15, df=10)
chi2
plot(ecdf(chi2), las=1, ylim=c(0,1.1))
curve(pchisq(x,10), 0,30, col=2, lwd=2, add=T)
stripchart(chi2, pch=16, col=3, cex=0.5, at=0, add=T)

x1=rchisq(20, df=5)
x2=rchisq(20, df=5)
x1
x2
plot(ecdf(x1), col=2, las=1)
lines(ecdf(x2), col=3)



##################
# Laboratorium 4 #
##################


# Zad 1
# Wykonano 50 rzutów kostką i otrzymano następujące wyniki:
# Liczba oczek: 1 2 3 4 5 6
# Liczba rzutów: 10 7 14 6 7 6
# b) Napisać funkcję, która dla zadanych wyników rzutu kostką rysuje wykres jej wartości empirycznych i teoretycznych.

# a) Na poziomie istotności α = 0.05 zweryfikować hipotezę, że kostka jest uczciwa (symetryczna).
# powinny byc >= 5
kostka=c(10,7,14,6,7,6)
kostka
names(kostka)=c(1:6)
kostka

#H0: p1=...=p6=1/6
#H1: ~H0

chisq.test(kostka, p=c(1/6,1/6,1/6,1/6,1/6,1/6))
#p-value = 0.3141>0.05 nie ma podstaw do odrzucenia H0
chisq.test(kostka) #  gdy wszystkie jednakowe wartości

h=chisq.test(kostka)
str(h)

chi2 = function(kostka,...)
{
  
  h=chisq.test(kostka,...) ## tw. obiekt
  
  M=rbind(h$observed,h$expected) ## macierz wyników
  
  if (h$p.value>=0.05) 
  { nap="Kostka uczciwa :)"} else
  { nap= "Kostka nieuczciwa !!!"}
  
  tytul=paste("chi-kw = ",round(h$statistic,2),", ",
              
              "p-value =", round(h$p.value,2),"\n",nap)
  
  b=barplot(M,beside=T,col=c(2,5),las=1,space=c(0.2,1),
            main=tytul,names.arg = c(1:length(kostka)))
  
  
  text(b,M+1,labels=round(M,1),xpd=T)
,}

chi2(c(10,7,14,6,7,6))
chi2(c(10,7,14,6,7,6), p=c(0.2,.3,.1,.1,.2,0.1))


# Zad 2
# Pewien stomatolog twierdzi,
# że proporcje rodzajów zabiegów w jego gabinecie są następujące
# 4 : 8 : 2 : 1 : 1 dla zabiegów służących utrzymaniu higieny stomatologicznej,
# leczenia zachowawczego, endodoncji, ekstrakcji i napraw protez.
# Wybrano losowo 150 pacjentów i okazało się,
# że 30 zostało poddanych zabiegom higienicznym, 64 miało leczenie zachowawcze,
# 28 endodontyczne, 16 ekstrakcję i 12 naprawę protez.
# Na poziomie istotności 0.05 testem χ² sprawdzić słuszność twierdzenia stomatologa.
zabiegi=c(30,64,28,16,12)
names(zabiegi)=c("hig.", "zach.", "endod.", "ekstr.", "naprawa")
zabiegi

#H0: p1=4/16, p2=8/16, p3=2/16, p4=1/16, p5=1/16
#H1: !H0

h1 = chisq.test(zabiegi, p=c(8/16, 4/16, 2/16, 1/16, 1/16))
h1
str(h1)
M=rbind(h1$observed,h1$expected)
M1=round(M,2)
M1
b=barplot(M1, beside=T, col=c(2,3), las=1, space=c(0.2,1))
text(b, M1+4, labels=M1, cex=0.8, xpd=T)
p=locator()
legend(p, fill=c(2,3), legend=c("dane empiryczne", "dane teorytyczne"),
       pch=16, xpd=T, cex=0.5)


# Zad 4
# W pewnym banku zaobserwowano liczbę obsługiwanych klientów na minutę
# w ciągu 200 jednominutowych okresów w pewnym miesiącu.
# Dane zebrane są w poniższej tabeli, gdzie xᵢ oznacza liczbę klientów w ciągu minuty,
# a nᵢ to ilość takich sytuacji:
# xᵢ: 0 1 2 3 4 5 6 7 8
# nᵢ: 14 31 47 41 29 21 10 5 2
# Zweryfikować hipotezę, że liczba klientów obsługiwanych w ciągu jednej minuty
# ma rozkład Poissona. Przedstawić wykres porównujący wartości teoretyczne z empirycznymi.

# X - liczba klientów na minutę
# H0: X ma rozkład z param. lambda
# H1: !H0
xi=c(0:8)
ni=c(14, 31, 47, 41, 29, 21, 10, 5, 2)
names(ni)=xi
ni
# Estymujemy parametr lambda 
lam = weighted.mean(xi,ni)
lam
sum(xi*ni)/sum(ni) # to samo co wyżej
# Łączymy dwie ostatnie kolumny, mała liczebność
ni1=c(14, 31, 47, 41, 29, 21, 10, 7)
names(ni1)=c(0:6, "          >=7(>6)")
ni1
#pr. teorytyczne
pr=c(dpois(c(0:6),lam), ppois(6,lam, lower.tail=F))
1-ppois(6,lam)
ppois(6,lam, lower.tail=F) # to samo co wyżej
pr
sum(pr) # Suma powinna być 1

h2=chisq.test(ni1,p=pr)
h2
# p-value = 0.9512 > 0.05 ---> nie ma podstaw do odrzucenia
M=rbind(h2$observed,h2$expected)
M1=round(M,2)
M1
b=barplot(M1, beside=T, col=c(2,3), las=1, space=c(0.2,1))
text(b, M1+4, labels=M1, cex=0.8, xpd=T)


# Zadanie 6
# Pewna firma wyprodukowała maszynę do gry w ruletkę.
# Przetestowano maszynę 100 razy i otrzymano następujące wyniki:
x=c(23, 6, 21, 24, 18, 11, 0, 33, 35, 16, 7, 28, 21, 27, 18, 6, 26, 31, 35, 13, 27, 0, 25, 4, 19, 17, 27, 4, 5, 33, 7, 26, 25,
    16, 21, 0, 9, 6, 6, 30, 7, 1, 23, 19, 1, 13, 8, 2, 2, 22, 19, 23, 11, 10, 17, 2, 26, 16, 15, 8, 12, 31, 13, 19, 15, 10, 19,
    23, 24, 27, 15, 30, 17, 22, 17, 33, 26, 34, 8, 6, 4, 27, 19, 21, 26, 4, 9, 7, 15, 30, 12, 9, 5, 23, 22, 18, 1, 17, 36, 1)
# Zbadać czy maszynę tę można uznać za uczciwą,
# tzn. że szansa wylosowania każdego z numerów 0, 1, ..., 36 jest taka sama.
table(x)

x3=table(factor(x, levels = 0:36))
x3

# Grupowanie - co najmniej 5 klas, co najmniej w każdej 5 liczb

k1=length(which(x<=6))
k2=length(which(x>=7 & x<=13))
k3=length(which(x>=14 & x<=20))
k4=length(which(x>=21 & x<=27))
k5=length(which(x>=28 & x<=36))
k=c(k1,k2,k3,k4,k5)
k
sum(k)

kat=c("0-6","7-13","14-20","21-27","28-36")
names(k)=kat
k

# Prawdopodobieństwa oddzielnie dla każdej klasy (np dla ostatniej, 28,29 ... = 9)
pt=c(7/37, 7/37, 7/37, 7/37, 9/37)

#H0: pi=pt
#H1: !H0

h=chisq.test(k,p=pt)
#p-value = 0.07859 > 0.05 - brak podstaw do odrzucenia

str(h)
m=rbind(h$observed,h$expected)
barplot(m, beside=T, col=c(3,4), las=1, space=c(0.1,1))
### cut - 2 sposob - bardziej prościej
granice=c(0,7,14,21,28,37)
table(cut(x,breaks=granice,right=F))
y=table(cut(x,breaks=granice,right=F))
pt=c(7/37, 7/37, 7/37, 7/37, 9/37)
chisq.test(y,p=pt)


# Zadanie 8
# Niech X oznacza wysokość (w cm) pewnego krzewu po pierwszym roku uprawy.
# Dane dotyczące 86 krzewów zebrane zostały w tabeli:
# X: < 35 | 35–45 | 45–55 | 55–65 | > 65
# Liczba obs.: 10 | 18 | 28 | 18 | 12
# Zbadać czy wysokość tego krzewu po pierwszym roku można modelować
# za pomocą rozkładu normalnego N(m = 50, σ = 15).

#N (m = 50, sig = 15)
# H0 : X~N(50, sig = 15)
# H1=~H0
liczeb=c(10,18,28,18,12)
names(liczeb)=c("<35","35-45","45-55","55-65",">65")
liczeb
m=50
s=15
granice=c(-Inf,35,45,55,65,Inf)
# F(-Inf) = 0, F(Inf) = 1

pnorm(35,m,s) # F(35)

pnorm(45,m,s) - pnorm(35,m,s) # F(45) - F(35) = P[35<=x<=45]
diff(pnorm(c(35,45),m,s))

granice=c(-Inf,35,45,55,65,Inf)
granice
diff(pnorm(granice, m ,s))
sum(diff(pnorm(granice, m ,s)))
prt=diff(pnorm(granice, m ,s))
chisq.test(liczeb,p=prt)
# p-value = 0.6371 > 0.05 - brak podstaw do odrzucenia H0



##################
# Laboratorium 5 #
##################


### Zad 1
# Zbadano maksymalną pojemność partii kondensatorów i otrzymano wyniki
# (w pF, czyli w pikofaradach):
# 62, 57, 70, 58, 59, 67, 65, 69, 55, 57, 60, 54, 72, 66, 74.
# Zweryfikować hipotezę, że rozkład maksymalnej pojemności kondensatorów jest normalny.
# Oszacować parametry rozkładu na podstawie próbki.
# Użyć testu Kołmogorowa i testu Shapiro-Wilka.

kond = c(62, 57, 70, 58, 59, 67, 65, 69, 55, 57, 60, 54, 72, 66, 74)
#H0: próba pochodzi z rozkładu norm.
#H1 : !H0
shapiro.test(kond)
# p-value = 0.4246 - brak podstaw do odrzucenia
qqnorm(kond)
qqline(kond)
# Test kołmogorowa
# Szacujemy parametry z próby
m1 = mean(kond)
s1=sd(kond)

m1
s1
ks.test(kond, "pnorm", m1, s1)
#p-value = 0.9085 - brak podstaw do odrzucenia H0
plot(ecdf(kond), las=1, col=2)
curve(pnorm(x,m1,s1), col=7, lwd=2, add=T)

# Interpretacja Shapiro wilka - wykresy Q-Q Nomr - tylko do zbadania normalności rozkładu ! 
# Test Kołmogorowa Smirnowa - bada rozkład między dyst. empiryczną a teroetyczną


### Zad 3
# Niech dana będzie próbka losowa:
# 2.94, 4.7, 7.14, 7.34, 13.46, 10.22, 3.21, 13.85, 3.55, 6.6, 6.73, 4.96, 10.27, 6.67, 4.5, 8.11, 7.48, 6.92, 12.4, 14.77
# Zbadać zgodność tego zbioru danych:
# a) z rozkładem wykładniczym z parametrem λ = 0.2,
# b) z rozkładem wykładniczym,
# c) z rozkładem chi-kwadrat,
# d) z rozkładem jednostajnym na przedziale [2, 16].
# W punktach (b) i (c) parametry rozkładów oszacować na podstawie próbki. Testy zilustrować wykresami porównującymi dystrybuanty lub kwantyle.

x = c(2.94, 4.7, 7.14, 7.34, 13.46, 10.22, 3.21, 13.85, 3.55, 
      6.6, 6.73, 4.96, 10.27, 6.67, 4.5, 8.11, 7.48, 6.92, 12.4, 14.77)
# Szacujemy parametr
lam = 1/mean(x)
lam
# Test Kołmogorowa
#H0: dane pochodzą z rozkładu wykładniczego
ks.test(x,"pexp", lam)
#  p-value = 0.02963 < 0.05 odrzucamy H0 na rzecz H1
## Wykres dystrybuanty teoret. i empir.
plot(ecdf(x), las=1)
curve(pexp(x,lam), col=2, lwd=2, add=T)
## Wykres QQ
plot(qexp(ppoints(x), rate=lam), sort(x), las=1, asp=1)
abline(0,1, col=2)
## Histogram
hist(x, freq = F, las=1)
curve(dexp(x,lam), col=2, lwd=2, add=T) #nakładamy gęstość
#c) Zgodność z Chi-kwadrat
# H0: dane pochodzą z Chi-kwadrat
# H1:!H0
# estymacja parametru df=k, k-liczba stopni swobody
x
df=mean(x)
df
ks.test(x,"pchisq", df)
# p-value = 0.7657 > 0.05 - przyjmujemy H0
par(mfrow=c(1,2)) # 2 wykresy w 1 rzędzie
plot(ecdf(x), las=1)
curve(pchisq(x,df), col=2, lwd=2, add=T)
plot(qchisq(ppoints(x), df), sort(x), las=1, asp=1)
abline(0,1, col=2)
dev.off()


### Zad 4
# Spośród studentów I roku informatyki wybrano losowo 12 studentów,
# zmierzono im wzrost i otrzymano wyniki (w cm):
# 176, 182.5, 166, 175, 175.5, 161.5, 173, 165, 186, 170.5, 158, 163.5.
# Analogiczne badanie zrobiono dla studentów II roku informatyki:
# 168, 172, 163, 171.5, 177, 190, 172.5, 164, 183.5, 171, 157.5, 166.
# Czy można twierdzić, że wzrost studentów I roku informatyki
# ma ten sam rozkład co wzrost studentów II roku informatyki?
# a) Przeprowadzić test Kołmogorowa-Smirnowa.
# b) Porównać wyniki za pomocą wykresu Q-Q.

wzrost1 = c(176, 182.5, 166, 175, 175.5, 161.5, 173, 165, 186, 170.5, 158, 163.5)
wzrost2 = c(168, 172, 163, 171.5, 177, 190, 172.5, 164, 183.5, 171, 157.5, 166)

#H0: wzrost studentów 1 roku ma taki sam rozkład jak wzrost st. 2 roku.
#H1: !H0
ks.test(wzrost1, wzrost2)
# p-value = 0.869 > 0.05 - przyjmujemy H0
# wykres dystrybuanty
plot(ecdf(wzrost1), col=2, las=1)
## Test Komogorowa dla 2 prób - bada odległości między 2 dystr. teoretycznymi!
lines(ecdf(wzrost2), col=5)
## Wykres QQ
qqplot(wzrost1, wzrost2, las=1, asp=1)
abline(0,1,col=2)
# ks.test - używamy na 2 sposoby !
# Jeśli będzie zadanie podobnego typu - to to co teraz zrobiliśmy - wystarczy! 

shapiro.test(wzrost1)
shapiro.test(wzrost2)
mean(wzrost1);mean(wzrost2)
sd(wzrost1);sd(wzrost2)

qqnorm(wzrost1)
qqline(wzrost1)


### Zad 5
# Przeprowadzono badania dotyczące pojemności płuc młodzieży szkolnej na wsi i w mieście
# i otrzymano poniższe dane (w cm³):
# | Pojemność płuc | Liczba uczniów w mieście | Liczba uczniów na wsi |
# |---|---|---|
# | 3100 − 3200 | 2 | 0 |
# | 3200 − 3300 | 8 | 0 |
# | 3300 − 3400 | 12 | 5 |
# | 3400 − 3500 | 15 | 10 |
# | 3500 − 3600 | 20 | 14 |
# | 3600 − 3700 | 24 | 20 |
# | 3700 − 3800 | 21 | 26 |
# | 3800 − 3900 | 17 | 34 |
# | 3900 − 4000 | 13 | 27 |
# | 4000 − 4100 | 10 | 22 |
# | 4100 − 4200 | 5 | 18 |
# | 4200 − 4300 | 3 | 12 |
# | 4300 − 4400 | 0 | 8 |
# | 4400 − 4500 | 0 | 4 |
# Zakładając, że pojemność płuc jest zmienną losową o ciągłej dystrybuancie,
# zweryfikować hipotezę H₀, że pojemność płuc młodzieży w mieście i na wsi
# ma taki sam rozkład.

Miasto = c(2, 8, 12, 15, 20, 24, 21, 17, 13, 10, 5, 3, 0, 0)
Wies = c(0, 0, 5, 10, 14, 20, 26, 34, 27, 22, 18, 12, 8, 4)

### Na kolowkium będą wektory do skopiowania żeby nie tracić czasu

#H0 : pojemność płuc młodzieży na wsi i w mieście ma ten sam rozkład
#H1 : !H0
# do testy K-S potrzebujemy niezgrupowanej próby
# odtwarzamy próbę i wyznaczamy środki klas
poj=seq(3150, 4450, 100)
poj
Miasto2=rep(poj,Miasto)
Miasto2
Wies2=rep(poj,Wies)
Wies2
sum(Miasto);sum(Wies)
length(Miasto2);length(Wies2)

ks.test(Miasto2, Wies2)
# p-value = 2.373e-07 < 0.05 - odrzucamy H0
plot(ecdf(Miasto2), col=2, las=1)
lines(ecdf(Wies2), col=5)
## Wykres QQ
qqplot(Miasto2, Wies2, las=1, asp=1)
abline(0,1,col=2)

stripchart(list(Miasto2, Wies2), pch=16, method = "jitter", jitter=0.2)

# Jeśli na kolokwium dostaniemy dane zgrupowane
# musimy odtworzyć prókę z środkami klas




##################
# Laboratorium 6 #
##################

### Zad 2
# W pewnym doświadczeniu rolniczym bada się plony nowej odmiany pszenicy
# w zależności od rodzaju nawozu.
# Otrzymano następujące plony dla trzech rodzajów nawozów
# (w kwintalach na hektar, 1 kwintal = 100 kg):
n1 = c(30.8, 32.6, 31.7, 33.1, 31.2, 28.3, 29.8, 32.0, 27.9, 28.5)
n2 = c(33.1, 31.8, 29.7, 29.0, 32.2, 33.1, 33.7, 30.4, 33.0, 28.9, 30.0)
n3 = c(32.5, 34.8, 34.6, 35.2, 33.4, 33.1, 32.8, 35.0, 34.2, 34.8, 33.9)
# a) Zweryfikować hipotezę, że rozkłady plonów dla każdego typu nawozu są jednakowe.
# b) Obliczyć średnią rangę dla każdej próbki.

# a) Średnia ranga
a = c(1,2,3)
b = c(1, 4, 3, 5)
d = c(2, 3, 4)
m = c(a, b, d)
rank(m)
sort(rank(m))
mean(rank(m))
mean(rank(a))
mean(rank(b))
mean(rank(d))

# Jeśli na egzaminie (nie na kolowkium) padnie pytanie - jak liczyć ranki

length(n1);length(n2);length(n3)
n=c(n1,n2,n3)
length(n)
# H0: rozkładu ploku dla każdego typu nawozu jest taki sam
# H1: !H0
k = kruskal.test(list(n1,n2,n3)) # musi być lista
# p-value = 0.0002218 < 0.05 - odrzucamy H0 na rzecz H1
str(k) # troszka za mało danych - więc na pichotę musimy wyznaczyć ranki

boxplot(list(n1,n2,n3), las=1, col=rainbow(3), main = "przenica")
stripchart(list(n1,n2,n3), pch=16, add=T, vertical=T)
stripchart(list(n1,n2,n3), pch=16, col=rainbow(3))

# Obliczyć średnią rangę dla każdej próby - za dużo roboty jeśli ręcnie
#b) 
lista = list(A = n1, B = n2, C = n3)
R1=stack(lista) # zamienia listę na ramkę danych
View(R1)
colnames(R1) = c("plony","odmiana")
R1$rangi = rank(R1$plony)
head(R1)
boxplot(plony~odmiana, las=1, col=rainbow(3), data=R1)
boxplot(rangi~odmiana, las=1, col=rainbow(3), data=R1)
aggregate(plony~odmiana, FUN=mean, data=R1)
mean(n1)
aggregate(rangi~odmiana, FUN=mean, data=R1)
# na pichotę
mean(R1$rangi[R1$odmiana=='A'])
mean(R1$rangi) # Średnia z całości


# Zadanie 3
# a) Wczytać plik csv-01(Orange).
# b) Zweryfikować hipotezę H₀, że rozkład wag pomarańczy jest w każdej plantacji taki sam.
# c) Obliczyć średnią rangę dla każdej próbki.

# Test Kruskala dla >= 3 prób. Potrzebna lista. 
# Trzeba stworzyć ramkę danych. Używamy aggregate

Pom=read.csv2(file.choose(), header=TRUE, sep=";", dec=".")
Pom
str(Pom)
View(Pom)
# H0: roz. wag pomarańczy jest w każdej plantacji taki sam
# H1: !H0
kruskal.test(Waga~Plantacja, data=Pom)
# p-value = 0.001158 < 0.05 - odrzucamy H0 na rzecz H1
# Ilustracją testu Kruskala jest boxplot
boxplot(Waga~Plantacja, data=Pom, col=rainbow(4), maun="Pomarańcze")
# Sprawdzić rangi
stripchart(Waga~Plantacja, data = Pom, vertical = T, add=T, pch=16)
Pom$Rangi=rank(Pom$Waga)
View(Pom)
aggregate(Rangi~Plantacja, data=Pom, FUN=mean)
mean(Pom$Rangi)


# Zadanie 4
# Dla zbioru danych airquality:
# a) Zweryfikować hipotezę, że rozkład poziomu ozonu w miesiącach od maja do września jest taki sam.
# b) Zweryfikować hipotezę, że rozkład temperatury w miesiącach od maja do września jest taki sam.
# c) Zweryfikować hipotezę, że rozkład temperatury w lipcu i sierpniu jest taki sam.

airquality
head(airquality)
tail(airquality)
#H0: rozkład tem. we wszystkich miesiący (V-IX) jest taki sam
#H1 : !H0
kruskal.test(Temp~Month, data=airquality)
# p-value = 4.496e-15 < 0.05 - odrzucamy H0
boxplot(Temp~Month, data=airquality,col=rainbow(4), maun="Miesiące")

lipiec=subset(airquality,Month==7)
lipiec
sierpien=subset(airquality,Month==8)
# H0: roz.temp. w lipcu i sierpniu jest taki sam
# H1: ~H0
ks.test(lipiec$Temp,sierpien$Temp)
# p-value = 0.191 > 0.05 - przyjmujemy H0

#Wykres dystrybuant empirycznych
plot(ecdf(lipiec$Temp), col=2, las=1)
lines(ecdf(sierpien$Temp), col=4)
# Wykres QQ
qqplot(lipiec$Temp,sierpien$Temp, asp=1)
abline(0,1, col=2, lwd=2)


### WAŻNE ABY DOBRZE WYTŁUMACZYĆ
### Teraz badamy niezależność statystyczną


# Zad 5
# Dla zbioru danych HairEyeColor, zweryfikować hipotezę,
# że kolor oczu mężczyzn jest cechą statystycznie niezależną od koloru włosów.

HairEyeColor
ramka=HairEyeColor
str(HairEyeColor)
dim(HairEyeColor)
View(ramka)

# Musimy wyciąfnać odpowiednie dane z tabelki
Male=ramka[,,1]
Male
str(Male)
is.matrix(Male)

#H0: kolor oczu mężczyzn jest cechą statystycznie niezależną od koloru włosą
# Do badaniu niez. używamy test analogiczny jak do zgodności 
# Ale tutaj musimy mieć tabelkę (chyba), a tam wektor

chisq.test(Male)
# p-value = 4.447e-06 < 0.05 - odrzycamy H0 (cechy są statystycznie zależne)
mosaicplot(Male, las=1, col=rainbow(4))
# Kiedy są niezależne - to na rysynku NIE powinno być schodków, lecz linii na jednym poziomie
barplot(Male, beside=T, col=rainbow(4), space=c(0.1,1))
# Kiedy tutaj te stosunki są w miarę równe - to wtedy niezależne
# Dodatkowo można zobaczyć ręcznie z tabelki liczą prd.
Male=cbind(Male,Suma1=rowSums(Male))
Male
Male=rbind(Male,Suma1=colSums(Male))
Male
56/279 # Prd. że losowo wybrana osoba ma włosy czarne
32/279 # Prd. że losowo wybrana osoba ma włosy czarne i oczy czarne
98/279 # Prd. że losowo wybrana osoba ma włosy czarne i oczy brązowe
32/98 # Czarne wł|brązowe oczy
(32/98) = (32/279)/(98/279)

# Zad 6 - NA PEWNO BĘDZIE TAKIE ZADANIE Z RĘCZNYM JAKBY DZIELENIEM NA KOLOWKIUM
# Niech X będzie liczbą spowodowanych wypadków drogowych w pewnym okresie czasu,
# a Y wiekiem kierowcy. Na podstawie poniższych danych zweryfikować hipotezę,
# że X i Y są niezależne.
# | X \ Y | 21−30 | 31−40 | 41−50 | 51−60 | 61−70 |
# |-------|-------|-------|-------|-------|-------|
# | 0     | 748   | 821   | 786   | 720   | 672   |
# | 1     | 74    | 60    | 51    | 66    | 50    |
# | 2     | 31    | 25    | 22    | 16    | 15    |
# | > 2   | 9     | 10    | 6     | 5     | 7     |

#H0: liczba spowodowanych wypadków nie zależy statyst. od wieku kierowcy
# H1: ~H0
M=rbind(c(748,821,786,720,672), c(74,60,51,66,50), c(31,25,22,16,15), c(9,10,6,5,7))
M
chisq.test(M)
# p-value = 0.2762 > 0.05 - przyjmujemy H0
mosaicplot(M, las=1, col=rainbow(5))
barplot(M, beside=T, col=rainbow(4), space=c(0.1,1))

M=cbind(M,Suma1=rowSums(M))
M=rbind(M,Suma1=colSums(M))
M
748/4194 #21-30 lat i 0 wypadków
862/4194 #21-30 lat
3747/4194 # 0 wypadków
748/862 # 0wyp|21-30 lat

# 3747/4194 # 0 wypadkow i 748/862 # 0wyp|21-30 lat
# różnią się niewiele , różnice są małe, dopuszczalne w ramach zwykłej losowości


# Zad 7
# Zbadać zależność między powierzchnią powiatu a liczbą jego ludności
# na podstawie danych csv-03(Powiaty).
Powiaty=read.csv2(file.choose(), header=TRUE, sep=";", dec=".",
              fileEncoding = "Windows-1250")
str(Powiaty)
head(Powiaty)
tail(Powiaty)
head(Powiaty[order(Powiaty$pow, decreasing=T), ], n=10)
plot(Powiaty$pow, Powiaty$lud)
plot(Powiaty$pow, Powiaty$lud, ylim=c(0,5000000))
# Musimy teraz stworzyć tablicę dwudzielną, aby zrobić test CHI 
summary(Powiaty$pow)
gr1=c(0,600,1200,3000)
pow1=cut(Powiaty$pow, breaks=gr1)
summary(Powiaty$lud)
gr2=c(19900,50000,80000,200000)
lud2=cut(Powiaty$lud, breaks=gr2)
tabela1 = table(pow1, lud2)
tabela1
abline(v=gr1, col=2)
abline(h=gr2, col=3)
chisq.test(tabela1)
#  p-value = 7.182e-05 < 0.05 - odrzucamy H0
library(TeachingDemos)
chisq.detail(tabela1)
cor(Powiaty$pow, Powiaty$lud)
# -0.09445116 - jeśli kowarancja jest duża - to zależne

# Warto zwrócić uwagę i poćwiczyć dzielenie granic - metodą prób i błędów
# Musi być >= 5 elementów w grupach
# Jeśli wychodzi mniej, to zrobić inny podział

# Jeśli mamy wektor i prd dane - to test zgodności
# Jeśli niezależność - to tam tablica dwudzielna
# I tam i tam - chi test
