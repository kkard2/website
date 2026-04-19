# R CLASS NOTES — MERGED

########################################################################

# # Zbiór rozwiązanych zadań z programowania w R

# ### Zrobione laboratoria

# - Zestaw 1 - podstawy rysowania wykresów
# - Zestaw 2 - rozkłady i bardziej zaawansowane wykresy
# - Zestaw 3 - przeprowadzanie eksperymentów z rozkładami i testy `chisq.test`
# - Zestaw 4 - porównywanie rozkładów próbki; `ks.test`, `shapiro.test`
# - Zestaw 5 - analiza danych: `kruskal.test`, `ks.test`; test niezależności `chisq.test`
# - **Kolokwium**

# ### Notatki:

# - `chisq.test` - Pozwala sprawdzić, czy dany rozkład warości odpowiada konkretnym prawdopodobieństwom, np: czy kostka jest uczciwa, czy próbka zgadza się z szacowanym prawdopodobieństwem.

# - W rozkładzie **Poissona**, trzeba zwrócić uwagę na liczebność próbek w zbiorach (jeśli ostatnie liczebności są małe, trzeba je zgrupować i zmodyfikować kategorie).

# - Dla **Poissona** szacowanie lambda:
#   `lambda <- weighted.mean(xi, ni)`

# - Dla **dwumianowego** szacowanie p:
#   `p <- weighted.mean(xi, ni) / sum(ni)`

# - Dla **normalnego** szacowanie m i sigma:
#   `m <- weighted.mean(mids, ni)`,
#   `sigma <- sqrt(sum(ni * ((mids - m) ^ 2)) / (sum(ni) - 1))`

# > **_NOTE:_** `ni` liczebność próbki, `xi` - kategorie (przedziały)

# - `shapiro.test` - Pozwala sprawdzić, czy próbka pochodzi z **rozkładu normalnego**.

# - Wykresy **Q-Q** pokazują, czy próbka ma rozkład liniowy, dobre do testu Shapiro.

# - `ks.test` - Pozwala sprawdzić, czy próbka jest zgodna z jakimś rozkładem lub czy dwie próbki podobny rozkład. Nie dla rozkładów dyskretnych (np. Poissona).

# - `kruskal.test` - Pozwala sprawdzić, czy kilka zbiorów próbek ma podobny rozkład.

# > **_NOTE:_** `ks.test` pozwala porównać tylko dwie próbki

# - `chisq.test` - **Test niezależeności**. Pozwala sprawdzić czy dane w postaci macierzy są od siebie niezależne.

# - Hipoteza zerowa jest przyjomowana jeśli **p value > 0.05**


########################################################################
# SET 1 — TASK 1
# set-1/task-1.r
########################################################################

punkty_1_x <- c(1, 20, 40, 80)
punkty_1_y <- c(20, 30, 13, 25)
plot(punkty_1_x, punkty_1_y, type = "l", col = 2, add = TRUE, lwd = 4,
     xlim = c(-10, 100), ylim = c(0, 55),
     main = "wykres 1", xlab = "argumenty", ylab = "wartości")

punkty_2_x <- c(5, 40, 80)
punkty_2_y <- c(30, 20, 3)
lines(punkty_2_x, punkty_2_y, col = 4, lwd = 4)

punkty_3_x <- c(-5, 30, 90)
punkty_3_y <- c(50, 10, 40)
points(punkty_3_x, punkty_3_y, col = 6, lwd = 4)


# NOTE:
# plot    - rysowanie wykresu z punktów (x, y)
# lines   - rysowanie wykresu w postaci lini (NIE line!)
# points  - rysowanie wykresu w postaci punktów

########################################################################
# SET 1 — TASK 2
# set-1/task-2.r
########################################################################

plot(0, 0, asp = 1, type = "n", xlim = c(-100, 100), ylim = c(-100, 100))

abline(0, 1, col = 1)
abline(0, 2, col = 2)
abline(0, 3, col = 3)
abline(0, 4, col = 4)
abline(0, 5, col = 5)
abline(2, 1, col = 6)

abline(h = 30, col = 7)

abline(v = -20, col = 8)
abline(v = 0, col = 9)
abline(v = 20, col = 10)
abline(v = 50, col = 11)
abline(v = 150, col = 12)


# NOTE:

# abline - pozwala na rysowanie funkcji liniowych oraz
# prostych pionowych i poziomych

# w celu przygotowania pustego wykresu można stworzyć
# plot typu "n" o odpowiednich wymiarach

########################################################################
# SET 1 — TASK 3
# set-1/task-3.r
########################################################################

X11()   # ze względu na linuxa
plot(0, 0, xlim = c(-10, 10), ylim = c(-10, 10), asp = 1, type = "n")
punkty <- locator(n = 5, type = "p")
punkty

# NOTE:
# locator do wybierania punktów na wykresie

########################################################################
# SET 1 — TASK 4
# set-1/task-4.r
########################################################################

x <- seq(50, 150, 0.1)

par(mfrow = c(2, 3))

curve(dnorm(x, mean = 100, sd = 16), from = 50, to = 150, xlab = "argumenty",
      ylab = "wartości", main = "Normalny, m = 100, s = 16")

curve(dunif(x, min = 0, max = 1), from = -0.5, to = 1.5, xlab = "argumenty",
      ylab = "wartości", main = "Jednostajny, a = 0, b = 1")

curve(dexp(x, rate = 1), from = 0, to = 20, xlab = "argumenty",
      ylab = "wartości", main = "Wykładniczy, lambda = 1")

curve(dchisq(x, df = 2), from = 0, to = 10, xlab = "argumenty",
      ylab = "wartości", main = "Chi-kwadrat, df = 2")

x_pois <- 0:20
y_pois <- dpois(x_pois, lambda = 7)
plot(x_pois, y_pois, type = "h", xlim = c(0, 20), xlab = "argumenty",
     ylab = "wartości", main = "Poisson, lambda = 7")

x_binom <- 0:20
y_binom <- dbinom(x_binom, size = 20, prob = 0.5)
plot(x_binom, y_binom, type = "h", xlim = c(0, 20), xlab = "argumenty",
     ylab = "wartości", main = "Poisson, lambda = 7")

par(mfrow = c(1, 1))

# NOTE:

# gęstości rozkładu normalnego -> liniowy
# gęstości rozkładu jednostajnego -> liniowy
# gęstości rozkładu wykładniczego -> liniowy
# gęstości rozkładu chi-kwadrat -> liniowy
# prawdopodobieństwa rozkładu poissona -> słupkowy (pionowe linie)
# prawdopodobieństwa rozkładu dwumianowego -> słupkowy (pionowe linie)

########################################################################
# SET 1 — TASK 5
# set-1/task-5.r
########################################################################


t <- seq(0, 2 * pi, length.out = 100)
x <- cos(t)
y <- sin(t)

plot(x, y, type = "l", asp = 1,
     xlab = "x", ylab = "y", main = "Okrąg o środku (0,0) i promieniu 1")
abline(h = 0, v = 0, lty = 2, col = "gray")

# NOTE:
# Równanie parametryczne okręgu: x = r*cos(t), y = r*sin(t)
# r = 1, t od 0 do 2*pi

########################################################################
# SET 1 — TASK 6
# set-1/task-6.r
########################################################################

my_function <- function(x) {
  x * sin(x)
}

my_function(2)

# NOTE:
# Funkcję przypisuje się do zmiennej, podobne do funkcji w JS

########################################################################
# SET 1 — TASK 7
# set-1/task-7.r
########################################################################

foo <- function(x) {
  if (x >= 0) {
    x^2
  } else {
    x * (-1)
  }
}

x <- seq(-5, 5, 0.1)
y <- sapply(x, foo)
plot(x, y, type = "l")

# NOTE:
# sapply - pozwala zastosować funkcję dla wektora danych wejściowych

########################################################################
# SET 1 — TASK 8
# set-1/task-8.r
########################################################################

fibonacci <- function(n) {
  if (n <= 0) return(numeric(0))
  if (n == 1) return(1)
  if (n == 2) return(c(1, 1))

  fib <- c(1, 1)
  for (i in 3:n) {
    fib[i] <- fib[i - 1] + fib[i - 2]
  }

  fib
}

fibonacci(10)

########################################################################
# SET 1 — TASK 9
# set-1/task-9.r
########################################################################

moje <- c(2, 13, 9, 6, 7, 40)
sekret <- round(runif(n = 6, min = 1, max = 49), 0)
trafienia <- intersect(moje, sekret)

cat("Moje", moje, "\n")
cat("Losowanie", sekret, "\n")
cat("Trafienia", trafienia, "\n")


# NOTE:
# możliwe są operacje na zbiorach np. intersect jako część wspólna

########################################################################
# SET 1 — TASK 10
# set-1/task-10.r
########################################################################

x <- runif(1000, 0, 1)
y <- runif(1000, 0, 1)

plot(x, y, las = 1, asp = 1)
rect(0, 0, 1, 1)

t <- seq(0, 2 * pi, length.out = 100)
x1 <- 0.5 + 0.5 * cos(t)
y1 <- 0.5 + 0.5 * sin(t)
lines(x1, y1, col = 3)

indeks <- which((x - 0.5)^2 + (y - 0.5)^2 <= 0.25)
indeks

plot(x[indeks], y[indeks], las=1, xlim=c(0,1), ylim=c(0,1), cex=0.5, col=4, asp=1) # nolint

pi_est <- 4 * length(indeks) / length(x)
pi_est

########################################################################
# SET 1 — TASK 11
# set-1/task-11.r
########################################################################

ny <- c(3.8, 5.5, 9.9, 15.7, 21.5, 26.3)
la <- c(19.5, 19.4, 19.7, 20.8, 21.3, 22.7)
fw <- c(13.7, 15.4, 20.0, 24.6, 28.5, 32.7)

m <- 1:6

plot(0, 0, xlim = c(1, 6), ylim = c(0, 30), main = "Pierwsze półrocze",
     ylab = "Temperatura", xlab = "Miesiąc")

lines(m, ny, col = 1, lwd = 2)
lines(m, la, col = 2, lwd = 2)
lines(m, fw, col = 3, lwd = 2)

########################################################################
# SET 2 — TASK 1
# set-2/task-1.r
########################################################################

seed(123)

dane <- rnorm(50, 100, 16)
wartosci <- hist(dane, col = 5, main = "Histogram")
str(wartosci)

stripchart(wartosci$mids, at = 0, pch = 16, add = TRUE)

text(wartosci$mids, wartosci$counts + 1, labels = wartosci$counts, xpd = TRUE)

# średnia próbki
m <- mean(dane)
# średnia szeregu rozdzielczego (pojedynczy słupek)
wm <- weighted.mean(wartosci$mids, wartosci$counts)

# wariancja danych zgrupowanych
var(dane)
sum((dane - m)^2 / (length(dane) - 1))

# wariancja danych niezgrupowanych
sum(wartosci$counts * (wartosci$mids - wm)^2) / (length(dane) - 1)

abline(v = m, lwd = 4, col = 2)

# NOTE:
# rysowanie histogramu
# średnia z próbki i szeregu
# wariancja danych zgrupowanych i nie zgrupowanych

########################################################################
# SET 2 — TASK 2
# set-2/task-2.r
########################################################################

dane <- rnorm(1000, 100, 16)

h <- hist(dane, breaks = 50, xlim = c(40, 160), freq = TRUE)
h <- hist(dane, breaks = 50, xlim = c(40, 160), col = 4, freq = FALSE) # freq = FALSE dla wykresu gęstości # nolint
str(h)

curve(dnorm(x, 100, 16), from = 40, to = 160, lwd = 4, col = 6, add = TRUE)

breaks <- c(30, 50, 60, 70, 90, 110, 150, 160)
h2 <- hist(dane, breaks = breaks, xlim = c(40, 160), col = 3)

h2 <- hist(dane, breaks = breaks, xlim = c(40, 160), col = 3, freq = FALSE)
curve(dnorm(x, 100, 16), from = 40, to = 160, lwd = 4, col = 5, add = TRUE)

# NOTE:
# wykres częstości i gęstości zmiennej losowej
# freq = FALSE - wykres gęstości

########################################################################
# SET 2 — TASK 3
# set-2/task-3.r
########################################################################

dane <- runif(n = 60, min = 50, max = 100)

h <- hist(dane, xlim = c(50, 100), col = 5, breaks = 12)

stripchart(dane, add = TRUE, at = 0, col = "red", pch = 19)

text(h$mids, h$counts + 0.2, label = h$counts)


# NOTE:
# stripchart - pozwala na rysowanie wykresu "kropkowego" na małych zbiorach
#              danych przydatne np w histogramie dla liczebności próbek

########################################################################
# SET 2 — TASK 4
# set-2/task-4.r
########################################################################

dane <- rchisq(n = 100, d = 10)

h <- hist(dane, xlim = c(0, 30), breaks = 20, col = 4, freq = FALSE)

stripchart(dane, at = 0, pch = 19, col = 2, add = TRUE)

curve(dchisq(x, df = 10), lwd = 4, col = 7, add = TRUE)

abline(v = mean(dane), lwd = 4, col = 8, add = TRUE)
abline(v = median(dane), lwd = 4, col = 9, add = TRUE)

legend(x = "topright", legend = c("mean", "median"), fill = c(8, 9))

# NOTE:
# wykres prawdopodobienstwa chisq
# średnia i mediana
# legenda do wykresu

########################################################################
# SET 2 — TASK 5
# set-2/task-5.r
########################################################################

dane <- read.csv2(file = "dane.csv", header = TRUE, sep = ",", dec = ".")

ncol(dane)
nrow(dane)
str(dane)

dane2 <- dane[c("hgt", "sex")]
head(dane2)

kobiety <- subset(dane2, sex == 0)
mezczyzni <- subset(dane2, sex == 1)

par(mfrow = c(1, 3))
hist(kobiety$hgt, col = 3)
hist(mezczyzni$hgt, col = 2)
hist(kobiety$hgt, col = 3)
hist(mezczyzni$hgt, col = 2, add = TRUE)
par(mfrow = c(1, 1))

########################################################################
# SET 2 — TASK 6
# set-2/task-6.r
########################################################################

dane <- rchisq(n = 15, df = 10)

# wykres dystrybuanty empirycznej
plot(ecdf(dane), main = "Dystrybuanta empiryczna i teoretyczna χ²(10)",
     xlab = "x", ylab = "F(x)", col = "blue", lwd = 2)

# wykres dystrybuanty teoretycznej
curve(pchisq(x, df = 10), add = TRUE, col = "red", lwd = 2, lty = 2)

# wykres próbki
stripchart(dane, add = TRUE, at = 0, col = "darkgreen", pch = 19)


dane <- rchisq(m = 100, df = 10)
plot(ecdf(dane), main = "Dystrybuanta empiryczna i teoretyczna",
     xlab = "x", ylab = "F(x)", col = 4, lwd = 2)
curve(pchisq(x, df = 10), add = TRUE, col = 5, lwd = 2, lty = 2)

# NOTE:
# dystrybuanta empiryczna - ecdf
# dystrybuanta teoretyczna
# wykres próbki

########################################################################
# SET 2 — TASK 7
# set-2/task-7.r
########################################################################

dane_1 <- rchisq(n = 20, df = 5)
dane_2 <- rchisq(n = 20, df = 5)
dane_3 <- rchisq(n = 20, df = 10)

plot(ecdf(dane_1), col = 2)
plot(ecdf(dane_2), col = 3, add = TRUE)
plot(ecdf(dane_3), col = 4, add = TRUE)

########################################################################
# SET 2 — TASK 8
# set-2/task-8.r
########################################################################

skumulowane_srednie <- function(wektor) {
  cumsum(wektor) / seq_along(wektor)
}

pwl_symulacja <- function(m = 100, n = 5) {
  plot(1:m, type = "n", xlim = c(1, m), ylim = c(0, 100),
       xlab = "n", ylab = "Średnia skumulowana", main = "Prawo wielkich liczb")
  for (i in 1:n) {
    proba <- runif(m, 0, 100)
    s_srednie <- skumulowane_srednie(proba)
    lines(1:m, s_srednie, col = i, lwd = 1.5)
  }
  abline(h = 50, col = "black", lwd = 2, lty = 2)
}

set.seed(123)
pwl_symulacja(m = 100, n = 10)

# NOTE:
# prawo wielkich liczb
# skumulowane średnie

########################################################################
# SET 2 — TASK 9
# set-2/task-9.r
########################################################################

symuluj_sume <- function(m, n_rysuj = 1) {
  s_m <- numeric(n_rysuj)
  for (j in 1:n_rysuj) {
    x <- runif(m, 0, 1)
    s_m[j] <- sum(x)
    if (n_rysuj == 1) {
      plot(1:m, cumsum(x), type = "l", main = paste("Ścieżka dla m =", m),
           xlab = "k", ylab = "Suma częściowa")
    }
  }
  s_m
}

set.seed(123)
cat("S_100 dla n=1:", symuluj_sume(100, 1), "\n")
cat("S_100 dla n=2:", symuluj_sume(100, 2), "\n")

s_100 <- replicate(100, sum(runif(100, 0, 1)))

par(mfrow = c(1, 2))
hist(s_100, main = "Sumy S_m (m=100, n=100)", xlab = "S_m", col = "lightblue")
s_stand <- (S_100 - 100*0.5) / (sqrt(100 * 1/12))
hist(s_stand, freq = FALSE, main = "Standaryzowane sumy", xlab = "Z", col = "lightgreen")
curve(dnorm(x), col = "red", lwd = 2)
par(mfrow = c(1, 1))

########################################################################
# SET 2 — TASK 10
# set-2/task-10.r
########################################################################

rzuty <- sample(1:6, 200, replace = TRUE)
tablica <- table(rzuty)
barplot(tablica, col = rainbow(6))


rzuty1 <- sample(1:6, 200, replace = TRUE)
rzuty2 <- sample(1:6, 200, replace = TRUE)
tab1 <- table(rzuty1)
tab2 <- table(rzuty2)

macierz <- rbind(tab1, tab2)
barplot(macierz, beside = TRUE, legend.text = c("Serie 1", "Serie 2"),
        main = "Dwie serie 200 rzutów kostką", xlab = "Liczba oczek", ylab = "Częstość",
        col = c("lightblue", "lightgreen"), ylim = c(0, max(macierz) + 10))

# NOTE:
# seria rzutów kostką
# tablica kontyngencji

########################################################################
# SET 3 — TASK 1
# set-3/task-1.r
########################################################################

kostka <- c(10, 7, 14, 6, 7, 6)
names(kostka) <- 1:6
kostka

# H0: kostka jest uczciwa, czyli jest równe prawdopodobieństwo
#     wypdadnięcia każdej ścianki

# H1: kostka nie jest uczciwa

# NOTE:
# Jeśli trzeba sprawdzić, czy dany rozkład wartości
# odpowiada konkretnym prawdopodobnieństwom
# (np. kostka dla każdej ścianki ma prawdopodobieństow 1/6)
# wtedy stosujemy chisq.test

test <- chisq.test(kostka, p = rep(1 / 6, 6))
test$p.value

if (test$p.value >= 0.05) {
  cat("Test chisq potwierda H0. Kostka jest uczciwa.")
} else {
  cat("Test chisq odrzuca H0. Kostka nie jest uczciwa.")
}

dane_teoretyczne <- rep(sum(kostka) / 6, 6)
matrix <- rbind(kostka, dane_teoretyczne)

barplot(matrix, col = c(2, 4), beside = TRUE)

########################################################################
# SET 3 — TASK 2
# set-3/task-2.r
########################################################################

proporcje_szacowane <- c(4, 8, 2, 1, 1)
prawdopodobienstwo_szacowane <- proporcje_szacowane / sum(proporcje_szacowane)

probka_empiryczna <- c(20, 64, 28, 16, 12)

# H0: Stomatolog ma dobre przeczucie i rozkład prawdopodobieństwa
#     jest zbliżony z jego szacowaniami

# H1: Stomatolog nie ma racji, odrzucamy H0

test <- chisq.test(probka_empiryczna, p = prawdopodobienstwo_szacowane)
test

if (test$p.value >= 0.05) {
  cat("Potwierdzamy H0. Proporcje zabiegów zgadzają się z szacowaniami.")
} else {
  cat("Odrzucamy H0. Proporcje zabiegów nie zgadzają się z szacowaniami.")
}


# jest 16 "próbek" szcowanych i 150 empirycznych, stąd skalowanie
matrix <- rbind(proporcje_szacowane * (150 / 16), probka_empiryczna) # nolint

barplot(matrix, col = c(2, 4), beside = TRUE)

########################################################################
# SET 3 — TASK 3
# set-3/task-3.r
########################################################################

doswiadczenie <- function(m, n) {
  wyniki <- c()
  for (i in 1:n) {
    rzuty <- sample(1:6, m, replace = TRUE)
    probka <- table(factor(rzuty, levels = 1:6))
    test <- chisq.test(probka, p = rep(1 / 6, 6))
    wyniki <- c(wyniki, test$statistic)
  }

  wyniki
}

wynik_doswiadczenia <- doswiadczenie(100, 100)

hist(wynik_doswiadczenia, freq = FALSE, col = "lightblue")
curve(dchisq(x, df = 6 - 1), lwd = 4, col = 3, freq = TRUE, add = TRUE)

krytyczna <- qchisq(1 - 0.05, df = 6 - 1)
abline(v = krytyczna, col = "blue", lwd = 2, lty = 2)


# NOTE:
# stopnie swobody dla rzutu kostką to 6 - 1
# freq = FALSE - wykres gęstości
# wartość krytyczna w chisq to alpha - 1

########################################################################
# SET 3 — TASK 4
# set-3/task-4.r
########################################################################

xi <- 0:8
ni <- c(14, 31, 47, 41, 29, 21, 10, 5, 2)
names(ni) <- xi
ni

# estymowanie parametru lambda
lambda <- weighted.mean(xi, ni)
lambda

# ze względu na małą liczebność, łączenie ostatnich kolumn
ni <- c(14, 31, 47, 41, 29, 21, 10, 7)
names(ni) <- c(0:6, ">=7")
ni

# wyznaczenie prawdopodobienstwa teoretycznego
pr_teor <- c(dpois(c(0:6), lambda), ppois(6, lambda, lower.tail = FALSE))
pr_teor
sum(pr_teor)

# test chi-kwadrat, sprawdzenie czy liczebność danych z próbki
# zgadza się z prawdopodobieństwem teoretycznym
test <- chisq.test(ni, p = pr_teor)

if (test$p.value >= 0.05) {
  cat("Potwierdzamy hipotezę H0: liczba klientów w ciągu minuty ma rozkład poissona") # nolint
} else {
  cat("Odrzucamy hipotezę H0")
}

# połączenie danych do wyświetlenia w barplot
matrix <- rbind(test$observed, test$expected)
barplot(matrix, beside = TRUE, col = c(2, 4))

# NOTE:
# rozkład poissona
# prawdopodobienstwo teoretyczne i empiryczne
# test chisq

########################################################################
# SET 3 — TASK 5
# set-3/task-5.r
########################################################################

xi <- 0:7
ni <- c(4, 6, 16, 12, 7, 2, 0, 1)

# obliczanie lambdy
lamb <- weighted.mean(ni, xi)
lamb

# ze względu na małą ilość danych trzeba zgrupować ostatnie kolumny
ni <- c(4, 6, 16, 12, 10)
names(ni) <- c(0:3, ">=4")
ni

# obliczenie prawdopodobienstwa teoretycznego
pr_teor <- c(dpois(0:3, lamb), ppois(3, lamb, lower.tail = FALSE))
pr_teor
sum(pr_teor)

test <- chisq.test(ni, p = pr_teor)
test

if (test$p.value >= 0.05) {
  cat("Potwierdzamy hipotezę H0: liczba zdobytych goli podczas meczu ma rozkład poissona") # nolint
} else {
  cat("Odrzucamy hipotezę H0")
}

m2 <- rbind(test$observed, test$expected)
barplot(m2, beside = TRUE, col = c(2, 4))

# NOTE:
# rozkład poissona
# prawdopodobienstwo teoretyczne i empiryczne
# test chisq

########################################################################
# SET 3 — TASK 6
# set-3/task-6.r
########################################################################

losowania <- c(23, 6, 21, 24, 18, 11, 0, 33, 35, 16, 7, 28, 21, 27, 18, 6, 26,
               31, 35, 13, 27, 0, 25, 4, 19, 17, 27, 4, 5, 33, 7, 26, 25, 16,
               21, 0, 9, 6, 6, 30, 7, 1, 23, 19, 1, 13, 8, 2, 2, 22, 19, 23,
               11, 10, 17, 2, 26, 16, 15, 8, 12, 31, 13, 19, 15, 10, 19, 23,
               24, 27, 15, 30, 17, 22, 17, 33, 26, 34, 8, 6, 4, 27, 19, 21, 26,
               4, 9, 7, 15, 30, 12, 9, 5, 23, 22, 18, 1, 17, 36, 1)

# przygotowanie tabeli z pogrupowanymi probkami
tab <- table(factor(x = losowania, levels = 0:36))
tab

# H0: ruletka jest uczciwa, czyli każdy numer ma równe prawodopodobieństwo
#     wylosowania

test <- chisq.test(tab, p = rep(1 / 37, 37))
test

if (test$p.value >= 0.05) {
  cat("Test potwierdza hipotezę H0, ruletka jest uczciwa")
} else {
  cat("Test odrzuca hipotezę H0, rulteka jest nie uczciwa")
}


# NOTE:
# uczciwa ruletka
# grupowanie próbek w tabelę

########################################################################
# SET 3 — TASK 7
# set-3/task-7.r
########################################################################

xi <- 0:5
ni <- c(4, 19, 41, 52, 26, 8)
names(ni) <- xi
ni

# estymowanie parametru p dla rozkładu dwumianowego
p <- weighted.mean(xi, ni) / sum(ni)
n <- 5

# oblicznie prawdopodobienstwa teoretycznego
pr_teor <- c(dbinom(0:5, size = n, prob = p))
pr_teor
sum(pr_teor)

test <- chisq.test(ni, p = pr_teor)
test

if (test$p.value >= 0.05) {
  cat("Test potwierdza hipotezę H0, krowy spełniają rozkład dwumianowy z estymowanym p") # nolint
} else {
  cat("Test odrzuca hipotezę H0, krowy nie spełniają rozkładu swumianowego")
}

# to samo tylko nie estymujemy parametru p
# estymowanie parametru p dla rozkładu dwumianowego
p <- 0.5
n <- 5

# oblicznie prawdopodobienstwa teoretycznego
pr_teor <- c(dbinom(0:5, size = n, prob = p))
pr_teor
sum(pr_teor)

test <- chisq.test(ni, p = pr_teor)
test

if (test$p.value >= 0.05) {
  cat("Test potwierdza hipotezę H0, krowy spełniają rozkład dwumianowy z p = 0.5") # nolint
} else {
  cat("Test odrzuca hipotezę H0, krowy nie spełniają rozkładu dwumianowego")
}

# NOTE:
# rozkład dwumianowy
# estymowanie parametru p

########################################################################
# SET 3 — TASK 8
# set-3/task-8.r
########################################################################

liczebnosc <- c(10, 18, 28, 18, 12)
names(liczebnosc) <- c("< 35", "35 - 45", "45 - 55",  "55 - 65",  "> 65")
liczebnosc

m <- 50
sigma <- 15

granica <- c(-Inf, 35, 45, 55, 65, Inf)
f_35 <- pnorm(35, m, sigma)   # F (35)
f_45 <- pnorm(45, m, sigma)   # F (45)
f_35_45 <- f_45 - f_35        # F (45) - F (35) <==> P(35 <= x <= 45)
f_35_45

diff(pnorm(c(35, 45), m, sigma)) # to samo co wyżej

# policzenie prawdopodobienstwa teoretycznego dla wszystkich przedziałów
pr_teor <- diff(pnorm(granica, m, sigma))
pr_teor

chisq.test(liczebnosc, p = pr_teor)

# NOTE:
# badanie rozkładu normalnego
# wyznaczanie prawdopodobienstwa na przedziałach - diff, pnorm

########################################################################
# SET 3 — TASK 9
# set-3/task-9.r
########################################################################

liczebnosc <- c(1, 16, 26, 19, 20, 18)
sr <- c((61 + 67) / 2, (67 + 69) / 2, (69 + 71) / 2, (71 + 73) / 2, (73 + 75) / 2, (75 + 81) / 2) # nolint
sr

granice <- c(61, 67, 69, 71, 73, 75, 81)

# szacowanie parametrow m i sigma dla rozkładu normalnego
m <- weighted.mean(sr, liczebnosc)
m
s <- sqrt(sum(liczebnosc * ((sr - m) ^ 2)) / (sum(liczebnosc) - 1))
s

# oblicanie prawdopodobiestwa teoretycznego
pr_teor <- diff(pnorm(granice, m, s))
pr_teor <- pr_teor / sum(pr_teor) # jeśli prawdopodobienstwo nie sumuje się do 1
pr_teor
sum(pr_teor)

test <- chisq.test(liczebnosc, p = pr_teor)
test

# NOTE:
# estymowanie parametrow do rozkładu normalnego m i sigma
# liczenie prawdopodobienstwa na przedziałach

########################################################################
# SET 4 — TASK 1
# set-4/task-1.r
########################################################################
liczebnosc <- c(62, 57, 70, 58, 59, 67, 65, 69, 55, 57, 60, 54, 72, 66, 74)

# H0: pojemności kondensatorów naleźą do rozkładu normalnego
s_test <- shapiro.test(liczebnosc)
s_test
# p-value > 0.05 - potwierdza to hipotezę H0

qqnorm(liczebnosc)
qqline(liczebnosc)

# szacowanie paramterów z próbki do testu kołmogorowa KS
m <- mean(liczebnosc)
s <- sd(liczebnosc)

ks_test <- ks.test(liczebnosc, "pnorm", m, s)
ks_test
# p-value > 0.05 - potwierdza to hipotezę H0

plot(ecdf(liczebnosc), col = 2)
curve(pnorm(x, m, s), col = 4, add = TRUE)

# NOTE:
# test shapiro pozwala sprawdzić czy próba pochodzi z rozkładu normalnego
# wykresy qq pokazują czy próbka ma rozkład liniowy, dobre do testu shapiro
# szacowanie parametrów m i s do testu KS
# wykres ecdf

########################################################################
# SET 4 — TASK 2
# set-4/task-2.r
########################################################################

probka <- c(55.1, 67.3, 54.6, 52.2, 58.4, 50.4, 70.1, 55.3, 57.6, 62.5, 65.2,
            68.4, 54.5, 56.7, 53.5, 61.6, 59.6, 49.0, 63.7, 58.1, 56.7, 57.8,
            63.6, 69.2, 60.8, 62.9, 54.3, 61.0, 58.2, 64.3, 57.4, 39.3, 59.0,
            60.1, 60.7, 59.9, 70.5, 57.2, 61.8, 46.0)

# H0: rozkład maksymalnej pojemności kondensatorów jest normalny

s_test <- shapiro.test(probka)
s_test
# p-value > 0.05 - potwierdza to hipotezę H0

qqnorm(probka)
qqline(probka)

# H1: rozkład maksymalnej pojemnosci kondenstatorów jest normalny o średniej 60
#     i wariancji 2.5

m <- 60
sd <- 2.5

ks_test <- ks.test(probka, m, sd)
ks_test
# p-value > 0.05 - potwierdza to hipotezę H1

plot(ecdf(liczebnosc), col = 2)
curve(pnorm(x, m, sd), col = 4, add = TRUE)

# NOTE:
# test shapiro, test ks

########################################################################
# SET 4 — TASK 3
# set-4/task-3.r
########################################################################

probka <- c(2.94, 4.7, 7.14, 7.34, 13.46, 10.22, 3.21, 13.85, 3.55, 6.6, 6.73,
            4.96, 10.27, 6.67, 4.5, 8.11, 7.48, 6.92, 12.4, 14.77)

# H0: próbka pochodzi z rozkładu wykładniczego, lambda = 0.2
test_1 <- ks.test(probka, "pexp", rate = 0.2)
test_1
# p-val < 0.05 - odrzuca to hipotezę H0
plot(ecdf(probka), col = 2)
curve(pexp(x, rate = 0.2), add = TRUE, col = 4)
# wykres qq dla H0
qqplot(qexp(ppoints(length(probka)), rate = 0.2), probka)
qqline(probka)

# H1: próbka pochodzi z rozkładu wykładniczego
est_lambd <- 1 / mean(probka)
test_2 <- ks.test(probka, "pexp", rate = est_lambd)
test_2
# p-val < 0.05 - odrzuca to hipotezę H1
plot(ecdf(probka), col = 2)
curve(pexp(x, rate = est_lambd), add = TRUE, col = 4)
# wykres qq dla H1
qqplot(qexp(ppoints(length(probka)), rate = est_lambd), probka)
abline(0, 1)

# H2: próbka pochodzi z rozkładu chi kwadrat 
test_3 <- ks.test(probka, "pchisq", df = mean(probka))
test_3
# p-val > 0.05 - potwierdza to hipotezę H2
plot(ecdf(probka), col = 2)
curve(pchisq(x, df = mean(probka)), add = TRUE, col = 4)
# wykres qq dla H2
qqplot(qchisq(ppoints(length(probka)), df = mean(probka)), probka)
abline(0, 1)

# H3: proóbka pochodzi z rozkładu jednostajnego na przedziale [2, 16]
test_4 <- ks.test(probka, "punif", min = 2, max = 16)
test_4
# p-val < 0.05 - odrzuca to hipotezę H3
plot(ecdf(probka), col = 2)
curve(punif(x, min = 2, max = 16), add = TRUE, col = 4)
# wykres qq dla H3
qqplot(qunif(ppoints(length(probka)), min = 2, max = 16), probka)
abline(0, 1)

# NOTE:
# test ks pozwala na sprawdzenie, czy próbka jest zgodna z jakimś rozkładem
# sprawdzanie rozkładów próbki

########################################################################
# SET 4 — TASK 4
# set-4/task-4.r
########################################################################

w_1 <- c(176, 182.5, 166, 175, 175.5, 161.5, 173, 165, 186, 170.5, 158, 163.5)
w_2 <- c(168, 172, 163, 171.5, 177, 190, 172.5, 164, 183.5, 171, 157.5, 166)

# H0: studenci mają taki sam rozkład wzrostu na 1 i 2 roku
test <- ks.test(w_1, w_2)
test
# p-val > 0.05 - potwierdza to hipotezę H0

# wykres emiprycznego rozkładu próbek
plot(ecdf(w_1), col = 2)
lines(ecdf(w_2), col = 4)

# porównanie próbek na wykresie qq
qqplot(w_1, w_2, lwd = 5, asp = 1, col = 4)
abline(0, 1)

# NOTE:
# test ks pozwala sprawdzić czy dwie próbki mają taki sam rozkład

########################################################################
# SET 4 — TASK 5
# set-4/task-5.r
########################################################################

miasto <- c(2, 8, 12, 15, 20, 24, 21, 17, 13, 10, 5, 3, 0, 0)
wies <- c(0, 0, 5, 10, 14, 20, 26, 34, 27, 22, 18, 12, 8, 4)

# H0: pojemność płuc dzieci na wsi i w mieście ma taki sam rozkad

# do testy Kołmogorowa Smiergowa (K-S) potrzebujemy niezgrupowanej próby
# odtwarzamy próbę

poj <- seq(3150, 4450, 100)

miasto_2 <- rep(poj, miasto)
wies_2 <- rep(poj, wies)

# liczebność się zgadza
sum(miasto); sum(wies)
length(miasto_2); length(wies_2)

test <- ks.test(miasto_2, wies_2)
test
# p-val < 0.05: hipoteza H0 jest odrzucona

plot(ecdf(miasto_2))
lines(ecdf(wies_2), col = 2)

qqplot(miasto_2, wies_2, asp = 1)
abline(0, 1, col = 3)

stripchart(list(miasto_2, wies_2), method = "jitter", jitter = 0.2)

# NOTE:
# zamiana danych zgrupowanych na dane ilościowe
# porównanie rozkładu w próbce

########################################################################
# SET 4 — TASK 6
# set-4/task-6.r
########################################################################

# a) H0 prawdziwa - próbki z rozkładu normalnego
p_wartosci_normalne <- replicate(1000, {
  proba <- rnorm(50)
  shapiro.test(proba)$p.value
})

# b) H0 fałszywa - próbki z rozkładu wykładniczego
p_wartosci_wykladnicze <- replicate(1000, {
  proba <- rexp(50, rate = 1)
  shapiro.test(proba)$p.value
})

# Test Kołmogorowa-Smirnowa dla zgodności z rozkładem jednostajnym [0,1]
ks_normalne <- ks.test(p_wartosci_normalne, "punif")
ks_wykladnicze <- ks.test(p_wartosci_wykladnicze, "punif")

cat("--- H0 prawdziwa (próbki normalne) ---\n")
print(ks_normalne)
cat("\n--- H0 fałszywa (próbki wykładnicze) ---\n")
print(ks_wykladnicze)

# Histogramy p-wartości
par(mfrow = c(1, 2))
hist(p_wartosci_normalne, breaks = 20, freq = FALSE,
     main = "p-wartości (H0 prawdziwa)", xlab = "p", col = "lightblue")
abline(h = 1, col = "red", lwd = 2, lty = 2)

hist(p_wartosci_wykladnicze, breaks = 20, freq = FALSE,
     main = "p-wartości (H0 fałszywa)", xlab = "p", col = "lightgreen")
abline(h = 1, col = "red", lwd = 2, lty = 2)
par(mfrow = c(1, 1))

# Dystrybuanty empiryczne
plot(ecdf(p_wartosci_normalne), col = "blue", lwd = 2,
     main = "Dystrybuanty p-wartości", xlab = "p", ylab = "F(p)")
lines(ecdf(p_wartosci_wykladnicze), col = "red", lwd = 2, lty = 2)
abline(0, 1, col = "black", lty = 3, lwd = 1)
legend("bottomright", legend = c("Normalne (H0 true)", "Wykładnicze (H0 false)", "U(0,1)"),
       col = c("blue", "red", "black"), lty = c(1, 2, 3), lwd = c(2, 2, 1))

########################################################################
# SET 5 — TASK 1
# set-5/task-1.r
########################################################################

# Polecenia zadania jest nie jasne:
# Symulacja statystyki chi-kwadrat, funkcja replicate( )
# więc nic nie robię :)

########################################################################
# SET 5 — TASK 2
# set-5/task-2.r
########################################################################

n1 <- c(30.8, 32.6, 31.7, 33.1, 31.2, 28.3, 29.8, 32.0, 27.9, 28.5)
n2 <- c(33.1, 31.8, 29.7, 29.0, 32.2, 33.1, 33.7, 30.4, 33.0, 28.9, 30.0)
n3 <- c(32.5, 34.8, 34.6, 35.2, 33.4, 33.1, 32.8, 35.0, 34.2, 34.8, 33.9)

# H0: rozkłady plonów dla każdego typu nawozu sa jednakowe (kruskal test)

test <- kruskal.test(list(n1, n2, n3))
test
# p-value < 0.05 - H0 jest odrzucona. Rozkład wśród nawozów nie jest jednakowy

boxplot(list(n1, n2, n3), col = c(2, 4, 6))
stripchart(list(n1, n2, n3), pch = 6, add = TRUE, vertical = TRUE)

#- Przykład tworzenia rangi ----------------------------------------------------
a <- c(1, 2, 3)
b <- c(1, 4, 3, 5)
d <- c(2, 3, 4)

m <- c(a, b, d)

rank(m)
sort(rank(m))
mean(rank(m))

mean(rank(a))
mean(rank(b))
mean(rank(d))
#-------------------------------------------------------------------------------

lista <- list(A = n1, B = n2, C = n3)
r1 <- stack(lista) # tworzy ramkę danych
r1
colnames(r1) <- c("plony", "odmiana")
View(r1)

r1$rangi <- rank(r1$plony)
head(r1)

boxplot(plony ~ odmiana, col = rainbow(3), data = r1)
boxplot(rangi ~ odmiana, col = rainbow(3), data = r1)

aggregate(plony ~ odmiana, FUN = mean, data = r1)
aggregate(rangi ~ odmiana, FUN = mean, data = r1)

# NOTE:
# test kruskala - jeśli trzeba porównać kilka zbiorów próbek pod względem
# podobieństwa rozkładu
# liczenie rangi

########################################################################
# SET 5 — TASK 3
# set-5/task-3.r
########################################################################

dane <- read.csv("set-5/pomarancza.csv", sep = ";")
# !!! R ma dziwne podejście do ścieżek, skoro dane są w tym samym
# folderze, a i tak trzeba podać nazwę (może VSCode coś tu psuje nwm)
head(dane)

# H0: rozkład wag pomarańczy jest taki sam w każdej plantacji

test <- kruskal.test(Waga ~ Plantacja, data = dane)
test
# p-value < 0.05 - H0 jest odrzucone, rozkład jest różny

boxplot(Waga ~ Plantacja, data = dane, col = rainbow(4))

dane$Rangi <- rank(dane$Waga)
View(dane)

aggregate(Rangi ~ Plantacja, data = dane, FUN = mean)
mean(dane$Rangi)


# NOTE:
# liczenie średniej rangi
# kruskal test

########################################################################
# SET 5 — TASK 4
# set-5/task-4.r
########################################################################

airquality
head(airquality)
tail(airquality)

# H0: rozkład poziomu ozonu od maja do września jest taki sam
#     (cały zbiór to dane od maja do września, więc nie trzeba nic dzielić)

test_oz <- kruskal.test(Ozone ~ Month, data = airquality)
test_oz
# p-value < 0.05 - obala H0, rozkład ozonu nie jest taki sam od V do IX
boxplot(Ozone ~ Month, data = airquality, col = rainbow(5),
        main = "Ozon od V do IX")

# H1: rozkład temperatur od maja do września jest taki sam

test_tmp <- kruskal.test(Temp ~ Month, data = airquality)
test_tmp
# p-value < 0.05 - obala H1, rozkład tempertatur nie jest taki sam od V do IX
boxplot(Temp ~ Month, data = airquality, col = rainbow(5),
        main = "Temperatura od V do IX")

# H2: rozkład tempertur od lipca do sierpnia jest taki sam

lipiec <- subset(airquality, Month == 7)
sierpien <- subset(airquality, Month == 8)

test_tmp_7_8 <- ks.test(lipiec$Temp, sierpien$Temp)
test_tmp_7_8
# p-value > 0.05 - potwierdza H2, rozkład temperatur w VII i VIII jest taki sam
boxplot(lipiec$Temp, sierpien$Temp, data = airquality, col = rainbow(2),
        main = "Temperatura od VII do VIII")

# NOTE: dla testu KS: dystrybuanty emiryczne (ecdf), wykres Q-Q
plot(ecdf(lipiec$Temp), las = 1, col = 2)
lines(ecdf(sierpien$Temp), col = 3)

qqplot(lipiec$Temp, sierpien$Temp, asp = 1)
abline(0, 1, col = 2)

# NOTE:
# test kruskala i ks
# wykres pudełkowy boxplot - kruskal
# wykres qq i ecdf - ks

########################################################################
# SET 5 — TASK 5
# set-5/task-5.r
########################################################################

tab <- HairEyeColor
View(tab)

# H0: kolor oczu u mężczyzn jest cechą statystycznie niezależną od koloru włosów

m <- tab[, , 1] # some magic numbers...
m

# NOTE: do testu niezależności chisq.test !!!
test <- chisq.test(m)
test
# p-value < 0.05 - obala H0, kolor oczu i włosów jest od siebie zależny

par(mfrow = c(1, 2))
mosaicplot(m, las = 1, col = rainbow(4), main = "oczy vs włosy")
barplot(m, beside = TRUE, col = rainbow(4))
par(mfrow = c(1, 1))

male <- tab[, , 1]
male <- cbind(male, Suma1 = rowSums(male))
male <- rbind(male, Suma2 = colSums(male))
male

# NOTE:
# test niezależności chisq.test
# wykres mozaikowy

########################################################################
# SET 5 — TASK 6
# set-5/task-6.r
########################################################################

m <- rbind(
  c(748, 821, 786, 720, 672),
  c(74, 60, 51, 66, 50),
  c(31, 25, 22, 16, 15),
  c(9, 10, 6, 5, 7)
)
colnames(m) <- c("21 - 30", "31 - 40", "41 - 50", "51 - 60", "61 - 70")
rownames(m) <- c("0", "1", "2", ">2")
m

# H0: liczba spowodowanych wypdaków nie zależy od wieku kierowcy

test <- chisq.test(m)
test
# p-val > 0.05 : przyjmujemy H0

par(mfrow = c(1, 2))
mosaicplot(m, las = 1, col = rainbow(5))
barplot(m, beside = TRUE, col = rainbow(4))
par(mfrow = c(1, 1))

m <- cbind(m, Suma1 = rowSums(m))
m <- rbind(m, Suma2 = colSums(m))
m

748 / 4194  # 21 -30 lat i 0 wypadków
862 / 4194  # wiek 21 - 30 lat
3747 / 4194 # 0 wypadków
748 / 862   # 0 wypadków pod warunkiem 21 - 30 lat
# różnią sie nie wiele (warunek nie ma wpływu na prawdopodobieństwo)

# NOTE:
# test niezależności chisq.test
# tworzenie macierzy do testu chisq
# wykres mozaikowy i słupkowy

########################################################################
# SET 5 — TASK 7
# set-5/task-7.r
########################################################################

dane <- read.csv("set-5/powiaty.csv", sep = ";", fileEncoding = "Windows-1250")
head(dane)

plot(dane$pow, dane$lud)

# H0: powierzchnia powiatu jest zależna od liczy ludności

summary(dane$pow)
granice_pow <- c(0, 600, 1200, 3000)
pow <- cut(dane$pow, breaks = granice_pow)

summary(dane$lud)
granice_lud <- c(19900, 50000, 80000, 2000000)
lud <- cut(dane$lud, breaks = granice_lud)

tab <- table(pow, lud)
tab

abline(v = granice_pow, col = 2)
abline(h = granice_lud, col = 3)

chisq.test(tab)
# p-val < 0.05 : odrzucamy H0

########################################################################
# SET 5 — TASK 8
# set-5/task-8.r
########################################################################

dane <- read.csv("set-5/miasta.csv", sep = ";", fileEncoding = "Windows-1250")
head(dane)

plot(dane$pow, dane$lud)

# H0: powierzchnia miasta i liczba ludności są niezależne
# H1: istnieje zależność między powierzchnią a liczbą ludności

summary(dane$pow)
summary(dane$lud)
range(dane$pow, na.rm = TRUE)
range(dane$lud, na.rm = TRUE)

granice_pow <- c(0, 50, 100, 600)
pow <- cut(dane$pow, breaks = granice_pow)

granice_lud <- c(0, 50000, 200000, 1800000)
lud <- cut(dane$lud, breaks = granice_lud)

tab <- table(pow, lud)
tab

abline(v = granice_pow, col = 2)
abline(h = granice_lud, col = 3)

chisq.test(tab)
# p-value < 0.05 - powierzchnia miasta i liczba ludności są niezależne

########################################################################
# SET 5 — TASK 9
# set-5/task-9.r
########################################################################

# Na podstawie poni»szej tabeli kontyngencji zbada¢, czy cechy X i Y s¡ statystycznie niezależne # nolint

m <- rbind(
  c(2, 3, 8),
  c(6, 5, 20)
)
colnames(m) <- c("y1", "y2", "y3")
rownames(m) <- c("x1", "x2")
m
str(m)

# H0: Cechy X i Y są niezależne (brak związku)
# H1: Cechy X i Y są zależne (istnieje związek)

test <- chisq.test(m)
test
# p-value > 0.05 - wartości są niezależne

barplot(m, beside = TRUE, col = c("blue", "red"),
        legend.text = rownames(m))
